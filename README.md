# NewSpadesSite

This will be the developer blog with integrated user platform of newSpades.

http://github.com/HendrikF/newSpades

## LICENSE

This repository is licensed under the terms of the GPLv3. See `LICENSE.md` for details.

## Installation

composer.json:

    "require": {
        "knplabs/knp-markdown-bundle": "~1.3",
    }

    $ composer install

AppKernel.php:

    $bundles = array(
        new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
    );

services.yml:

    services:
        app.form.type.tags:
            class: AppBundle\Form\Type\TagsType
            arguments: ["@doctrine.orm.entity_manager"]
            tags:
                - { name: form.type, alias: tags }
        app.form.type.post:
            class: AppBundle\Form\Type\PostType
            tags:
                - { name: form.type, alias: post }
        app.form.type.tag:
            class: AppBundle\Form\Type\TagType
            tags:
                - { name: form.type, alias: tag }
        app.form.type.user:
            class: AppBundle\Form\Type\UserType
            tags:
                - { name: form.type, alias: user }
