# Craftcms Starter Template

![photo_2021-03-02 11 52 51](https://user-images.githubusercontent.com/28866565/109638108-e59e7f00-7b4d-11eb-88f6-601c98bd101c.jpeg)

## Components/Templates

- Title
- Button
- Pagination
- Image
- Links
- Posts with pagination
- Header with responsive menu
- Footer

All the styles is done with `tailwindcss` framework and all the configuration is already done with the help of `laravel-mix`. 
When developing your theme you can use `yarn watch` and browsersync is already configured. The `PRIMARY_SITE_URL` will be used as proxy for browsersync to connect to reach the website, but you can edit this behaviour in the `webpack.mix.js`.

```
PRIMARY_SITE_URL="http://url-to-my-site.test"
```

## Plugins

This is a simple CraftCMS template with a few usefull plugins already installed: 
``` 
"craftcms/redactor": "2.8.5",
"ether/seo": "3.6.7",
"pennebaker/craft-architect": "2.4.1",
"sebastianlenz/linkfield": "1.0.25",
```

## Start

```
git clone https://github.com/giorgiopogliani/craftcms-starter-template.git website
cd website
composer install 
cp .env.example .env
php craft setup/security-key
mysql -uroot -p -e "create database example"
```

or you can also use composer

```
composer create-project giorgiopogliani/craftcms-starter-template --stability=dev website
```

Edit your `.env` to match your configuration.

```
php craft install/craft 
npm install
npm run watch
```

## Deploy

#### deplpy.sh
You can use the deplpy.sh bash script. It's just a simple wrapper arouend rsync and lftp to push files to a remote server. 

#### Nod
You can check out my other simple utility, written in php and can be installed globaly, it's still a work in progress though: [https://github.com/giorgiopogliani/nod](https://github.com/giorgiopogliani/nod).

#### deployphp/deployer
You can find a deploy.php that work with [deployer](https://github.com/deployphp/deployer), a zero down-time deploy utilty. You should update the configuration with your deatails to make it work. In the `.github` folder there is also a deploy.yml to deploy with github actions.
 
