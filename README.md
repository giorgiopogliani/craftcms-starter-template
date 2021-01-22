# craftcms-starter-template

This is a simple CraftCMS template with a few usefull plugins already installed: 
``` 
"craftcms/redactor"
"ether/seo"
"marionnewlevant/picture"
"sebastianlenz/linkfield"    
```

All the styles is done with `tailwindcss` framework and all the configuration is already done with the help of `laravel-mix`. 
When developing your theme you can use `yarn watch` and browsersync is already configured. The `DEFAULT_SITE_URL` will be used as proxy for browsersync to connect to reach the website, but you can edit this behaviour in the `webpack.mix.js`.

```
DEFAULT_SITE_URL="http://url-to-my-site.test"
```

# Start

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

# Deploy

I have created a simple utility to help me with deploys. You can check out it here:     
 
