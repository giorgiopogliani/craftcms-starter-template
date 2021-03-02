#!/usr/bin/env bash
USER=""               # Your username
PASS=""               # Your password
HOST=""               # Your hostname (e.g. example.com)
LCD="."               # Your local directory 
RCD="/public_html/"   # Your remote server directory (e.g. /var/www/example.com)

EXCLUDE=" 
--exclude web/images \
--exclude web/cpresources \
--exclude vendor \
--exclude storage \
--exclude node_modules \
--exclude deploy.sh \
--exclude .idea \
--exclude .git \
--exclude .env \
--exclude .DS_Store \
"

watch() {
  echo watching folder "$1"
  while true
  do
      files=$(find "$1" -type f -mtime -2s)
      if [[ $files == "" ]] ; then
          sleep 2
      else
          echo changed, "$files"
          push
          sleep 2
      fi
  done
}

function push(){
  if [[ -n "$SSH" ]]; then
    rsync -r --update $EXCLUDE -v -e "$SSHCONFIG" $LCD/$PUSH $USER@$HOST:$RCD/$PUSH
  else
    lftp -f "
      open $HOST
      user $USER '$PASS'
      lcd $LCD
      set ftp:ssl-allow no
      mirror ${EXCLUDE//[$'\t\r\n\\']} --reverse --continue --parallel=2 $LCD/$PUSH $RCD/$PUSH
    "
  fi
}

function pull(){
  if [[ -n "$SSH" ]]; then
    rsync -r --update $EXCLUDE -v -e "$SSHCONFIG" $USER@$HOST:$RCD/$PULL $LCD/$PULL
  else
    lftp -f "
      open $HOST
      user $USER '$PASS'
      lcd $LCD
      set ftp:ssl-allow no
      mirror ${EXCLUDE//[$'\t\r\n\\']} --only-newer --continue --parallel=2 $RCD/$PULL $LCD/$PULL
    "
  fi
}

PARAMS=""
while (( "$#" )); do
  case "$1" in
    -b|--build)
      BUILD="true"
      shift 1
      ;;
    -w|--watch)
      WATCH=$2
      shift 2
      ;;
    -u|--push)
      PUSH=$2
      shift 2
      ;;
    -p|--pull)
      PULL=$2
      shift 2
      ;;
    -s|--ssh)
      SSH=true
      shift 1
      ;;
    --upload-vendor)
      VENDOR=true
      shift 1
      ;;
    -h|--help)
      echo "
Mini Craft Scripts 0.2.2

  -u|--push  [path]   Upload stuff to server.
  -p|--pull  [path]   Download stuff from server.
  -w|--watch [path]   Watch for local filesystem changes.
  -s|--ssh            Sync stuff with ssh configuration, default is ftp.
  --upload-vendor     This command quickly upload the vendor folder using zip.
  -b|--build          Run yarn dev before deploy.
  -h|--help           This help.

Example:
bash deploy.sh --ssh --watch templates
bash deploy.sh --pull web/images
bash deploy.sh --build 
      "
      exit 0
      ;;
    --) # end argument parsing
      shift
      break
      ;;
    -*) # unsupported flags
      echo "Error: Unsupported flag $1" >&2
      exit 1
      ;;
    *) # preserve positional arguments
      PARAMS="$PARAMS $1"
      shift
      ;;
  esac
done

if [[ -n "$VENDOR" ]]; then
  if [[ -n "$SSH" ]]; then
    zip -r vendor.zip vendor
    bash deploy.sh --ssh -u vendor.zip
    $SSHCONFIG $USER@$HOST "cd $RCD && unzip vendor.zip";
    rm vendor.zip
    exit 0
  else
    zip -r vendor.zip vendor
    lftp -f "
      open $HOST
      user $USER '$PASS'
      lcd $LCD
      set ftp:ssl-allow no
      mput $LCD/vendor.zip $RCD/vendor.zip
    "
    rm vendor.zip
    echo "Use your hosting provider panel to unzip the vendor folder."
    exit 0
  fi
fi

if [[ -n "$BUILD" ]]; then
  yarn dev
fi

if [[ -n "$WATCH" ]]; then
    watch "$WATCH"
else
  if [[ -n "$PULL" ]]; then
    pull
  else 
    push
  fi
fi