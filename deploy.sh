#!/usr/bin/env bash

USER=""               #Your username
PASS=""               #Your password
HOST=""               #Keep just the address
LCD="."               #Your local directory
RCD="/public_html/"   #FTP server directory

watch() {
  echo watching folder "$1"
  while true
  do
      files=$(find "$1" -type f -mtime -2s)
      if [[ $files == "" ]] ; then
          sleep 2
      else
          echo changed, "$files"
          sync
          sleep 2
      fi
  done
}

function sync(){
  lftp -f "
  open $HOST
  user $USER $PASS
  lcd $LCD
  set ftp:ssl-allow no
  mirror --exclude vendor --exclude web/cpresources  --exclude web/images --exclude storage --exclude .git --exclude node_modules  --exclude .idea --exclude .DS_Store --exclude deploy.sh --only-newer --reverse --delete --continue  --parallel=2 $LCD $RCD
  "
}

function put(){
  lftp -f "
  open $HOST
  user $USER $PASS
  set ftp:ssl-allow no
  mput ./$1 $RCD
  "
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
    -u|--upload)
      UPLOAD=$2
      shift 2
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

if [[ -n "$BUILD" ]]; then
  yarn dev
fi


if [[ -n "$UPLOAD" ]]; then
  put "$UPLOAD"
  exit 1
fi

if [[ ! -z "$WATCH" ]]; then
    watch $WATCH
else
    sync
fi
