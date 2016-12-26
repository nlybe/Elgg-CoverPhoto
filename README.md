Cover Photo for Entities
========================

![Elgg 2.2](https://img.shields.io/badge/Elgg-2.2-orange.svg?style=flat-square)

This plugin offers the option to upload cover photo to Elgg Entities.

## Features
- Option to choose in plugin settings the type/subtype of entities for which to enable cover photo
- For entities type selected, an option to edit the cover photo is added on entity menu
- If [cropper](https://github.com/nlybe/Elgg-Cropper) plugin is enabled, a responsive image cropping tool is available to crop the cover photo

## How to Use
1. Enable the plugin
2. In plugin settings, check the type/subtype of entities for which need to enable cover photo feature
3. On object view, include the following code

```php
if ($entity->covertime) {                    
    echo elgg_view('output/img', array(
        'src' => amap_cp_getCoverIconUrl($entity, 'large'),
        'alt' => elgg_echo('cover'),
    ));
}
```

## Future Improvements
- [ ] Add on CoverPhoto entity the container_guid indicating the parent entity
- [ ] Add method CoverPhoto->getImageUrl()

