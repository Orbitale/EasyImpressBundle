
Impress Portfolio with a simple Symfony bundle
==============================================

Want to create awesome presentations based on [Impress.js](https://github.com/bartaz/impress.js)?

With EasyImpressBundle, you can create presentations based on a single `yml` configuration file.

[View the online demo](http://demo.orbitale.io/easy_impress/)

# Requirements

* PHP 5.5+ / 7.0+
* [Composer](https://getcomposer.org/)

# Installation

* Install the bundle:
   ```shell
   $ composer require orbitale/easyimpress-bundle
   ```
* Add it to your Kernel:
    ```php
    <?php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = [
                // ...
                new Orbitale\Bundle\EasyImpressBundle\EasyImpressBundle(),
            ];
        }
    }
    ```
* Add routing instructions
    ```yml
    # app/config/routing.yml
    easy_impress:
        resource: '@EasyImpressBundle/Resources/config/routing.yml'
        prefix: /presentations    # not mandatory, but very useful
    ```
* Install necessary assets:
    ```bash
    $ php bin/console assets:install --symlink --relative 
    ```
* Start creating presentations in your `%kernel.root_dir%/config/presentations/` directory!

# Usage

Every slider is contained in the `app/config/presentations` directory by default, and the file name is used as the
slider's identifier. This identifier will be the name displayed in the URL.

**👉 Tip:** You can override this directory by changing EasyImpress' configuration, [view below](#configuration-reference).

`app/Resource/presentations/{presentation_name}` will be accessible from `/{presentation_name}` path.

## Configuration and yaml files processing

Every file will be added to the container as a resource, so if it's modified in dev, cache will automatically be refreshed.

Yml files are found by Symfony `Finder` in the [PresentationsPass](./DependencyInjection/Compiler/PresentationsPass.php).

Presentations and slides configurations are processed via Symfony `Config` component, you can check in the
[Configuration](./Configuration) directory for the configuration classes and references.

# Retrieve presentations

You can get all presentations in the `easy_impress` service, they will be transformed from arrays to immutable objects
 at runtime.

## Yml reference

As every presentation is made in the `yml` format, here's the reference with default values:

```yaml
# Html "data-" attributes that correspond to Impress options
data:
    transition-duration: 1000
    min-scale: 1

# Determines the css "opacity" for inactive slides (".future" or ".past" slide classes)
inactive_opacity: 1

# Some HTML attributes for the presentation
# Please note that "impress_slides_container" class is mandatory and always added
attr:
    style: ''
    class: 'impress_slides_container'

# With increments, the slides coordinates will automatically be calculated based on these values
# For example, if "x" increment is set to 100, each slide "x" value will be incremented with 100.
# Increments will also correspond to base values for the first slide.
# IMPORTANT: If you set increments for one property, you CANNOT set the property in a slide.
increments:
    x:        ~
    y:        ~
    z:        ~
    rotate:   ~
    rotate-x: ~
    rotate-y: ~
    rotate-z: ~

# Here you will define all slides
# Slides are an array of properties
slides:

    # Slide ID will be processed automatically with this as default value:
    # {presentation_name}_{slide_number}
    #
    # But you can specify an id manually:
    #
    # slides:
    #     slide_id:
    #         data:
    #             x: 1
    #
    # You can specify no id at all:
    #
    # slides:
    #     - data:
    #           x: 1
    #
    # Or add it as a simple property (make sure there is no duplicate):
    #
    # slides:
    #     - id: slide_id
    #       data:
    #           x: 1
    #

    slide id or hyphen:

        # Optional, see id informations above
        id: ''

        # Slide's content, in plain HTML
        content: ''

        # HTML data attributes that correspond to slide's position/rotation in the canvas
        # All of these will correspond to CSS transforms
        data:
            x:        ~
            y:        ~
            z:        ~
            rotate:   ~ # Alias to "rotate-z"
            rotate-x: ~
            rotate-y: ~
            rotate-z: ~
            scale:    ~ # 

        # Some HTML attributes for the slide
        # Please note that "step" class is mandatory and always added
        attr:
            style: ''
            class: 'step'

        # If you are using "increments" in presentation,
        #   you can reset any incrementation value starting from this slide
        #   by setting the attribute to "true".
        # The slide that resets value will recover the base increment value
        #   and incrementation will continue for the next slides.
        reset:
            x:        false
            y:        false
            z:        false
            rotate:   false
            rotate-x: false
            rotate-y: false
            rotate-z: false
```

### Data attributes

As explained in [ImpressJS Wiki](https://github.com/impress/impress.js/wiki/Html-attributes):

> ### Cartesian Position
> Where in 3D space to position the step frame in Cartesian space.
> 
> #### data-x, data-y, data-z
> Define the origin location in 3D Cartesian space. Specified in pixels (sort-of).
> 
> #### data-rotate
> Rotation of the step frame about its origin in the X-Y plane. This is akin to rotating a piece of paper in front of your face while maintaining it's ortho-normality to your image plane (did that explanation help? I didn't think so...). It rotates the way a photo viewer rotates, like when changing from portrait to landscape view.
> 
> ### Polar Position
> Rotation of the step frame about its origin along the theta (azimuth) and phi (elevation) axes. This effect is similar to tilting the frame away from you (elevation) or imaging it standing on a turntable -- and then rotating the turntable (azimuth).
> 
> #### data-rotate-x
> Rotation along the theta (azimuth) axis
> 
> #### data-rotate-y
> Rotation along the phi (elevation) axis
> 
> ### Size
> 
> #### data-scale
> The multiple of the "normal" size of the step frame. Has no absolute visual impact, but works to create relative size differences between frames. Effectively, it is controlling how "close" the camera is placed relative to the step frame.

More information can be found on the [Impress.js Wiki](https://github.com/bartaz/impress.js/wiki) or the
[Impress.js documentation](https://github.com/bartaz/impress.js).

# Configuration reference

```yml
easy_impress:
    presentations_dir: '%kernel.root_dir/config/presentations'
    layout:            '@EasyImpress/layout.html.twig'
```

# License

This bundle is provided with MIT license, any contribution should be made under the same license.
