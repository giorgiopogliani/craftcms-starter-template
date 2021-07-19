# Craftcms Starter Template

Simple craft cms starter template fully responsive, built with Tailwind CSS, AlpineJS 3.0, ViteJS and Twig Components (like Laravel Blade Components but for twig).

## Start
```
composer create-project giorgiopogliani/craftcms-starter-template --stability=dev website
```

Copmlete the setup or edit your manually update your `.env` file to match your configuration. To manually install craft run this command.

```
php craft install/craft 
```

After installing craft install the vite plugin, then you can install dependencies and start vite dev server.
```
php craft plugin/install vite
npm install
npm run dev
```

If your environment is dev, the vite plugin will try to access the dev server, in production the vite plugin will try to access compiled assets. More info at [https://nystudio107.com/docs/vite/](https://nystudio107.com/docs/vite)

## Macros
- Forms
- Image
- Menu
- Image
- Pagination
- Title

## Components with [Twig Components](https://github.com/giorgiopogliani/twig-components)
- container
- title
- button
- logo

## Blocks
- text: two columns layout section

## Pages
- 404
- 503
- Posts (entry, index and item)

## Partials (in _layoyts)
- favicon (with asset field in globals)
- footer
- header
- seo (ether/seo plugin)

## Extensions
added functions, available globally with a twig extension, you can add your own at `modules/extensions\UtilsExtension.php`
- is_homepage

## Preview
![craftcms-starter-template](https://user-images.githubusercontent.com/28866565/126156641-a7009300-316b-49fa-8010-82d421e8035a.png)

## Plugins

List of preinstalled plugins to solve common task when building a website.
``` 
craftcms/redactor 
ether/seo 
nystudio107/craft-vite
pennebaker/craft-architect 
performing/twig-components 
sebastianlenz/linkfield 
```

## Deploy

### deploy.sh
Very simple script to upload all files to a remote location. It works as a wrapper of lftp or rsync. You can update the configuration at the start of the file.

### deployphp/deployer
You can find a deploy.php that work with [deployer](https://github.com/deployphp/deployer), a zero down-time deploy utilty. You should update the configuration with your deatails to make it work. In the `.github` folder there is also a deploy.yml to deploy with github actions.
 
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
