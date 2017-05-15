# Getting Started With FrameworkSearchBundle

The searchbundle provides a way to integrate very basic search functionality
into our little framework.

## Installation

    composer require sumocoders/framework-search-bundle

Enable the bundle in the kernel.

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    // ...
    $bundles = array(
        // ...
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new SumoCoders\FrameworkSearchBundle\SumoCodersFrameworkSearchBundle(),
    );
}
```

## Usage

First off all you will need a basic understanding on how the search works. The
actual search isn't performed on the entities itself but on an search index.

So to be able to search in your entities/items you will need to add them into
the search-index. Below you will find more detailed examples where we explain
how you can insert/update or delete items in the search-index.

All of this is implemented with the use of events. So you should trigger events
whereon this bundle will listen.

Of course this is just one part of the search-functionality. The second part is
displaying the results, this is also implemented with events. Only in this case
your bundle will need to listen on our event (`search.search`).

When this event is triggered your bundle will need to inspect the event and has
the responsibility to fill the results based on the ids that are passed. Below
you can find an example-implementation.

### Add or update entities/items into the search index

```php

    // check if the search bundle is registered
    if (array_key_exists(
        'SumoCodersFrameworkSearchBundle',
        $this->container->getParameter('kernel.bundles')
    )
    ) {
        // create update event
        $event = new IndexUpdateEvent();
        // add index fields to update event
        $event->addObject(new IndexItem(User::class, $user->getId(), 'email', $user->getEmail()));
        $event->addObject(new IndexItem(User::class, $user->getId(), 'username', $user->getUsername()));
        // dispatch the event
        $this->get('event_dispatcher')->dispatch('framework_search.index_update', $event);
    }
```

### Remove entities/items from the search index

```php

    // check if the search bundle is registered
    if (array_key_exists(
        'SumoCodersFrameworkSearchBundle',
        $this->container->getParameter('kernel.bundles')
    )
    ) {
        // create a new delete event
        $event = new \SumoCoders\FrameworkSearchBundle\Event\IndexDeleteEvent(
            'SumoCoders\FrameworkUserBundle\Entity\User',
            $user->getId()
        );
        // dispatch the event
        $this->get('event_dispatcher')->dispatch('framework_search.index_delete', $event);
    }
```

### Create an event listener

```php
    public function onSearch(SearchEvent $event): void
    {
        $users = $this->repository->findById($event->getFoundItems()[User::class]);
        $class = User::class;
        $bundle = ucfirst($this->translator->trans('user.header.title'));
        foreach ($users as $user) {
            $event->addResult(new SearchResult(
                $class,
                $user->getId(),
                $bundle,
                $user->getUsername() . '(' . $user->getEmail() . ')',
                $this->router->generate('route_to_detail_page')
            ));
        }
    }
```

### Register the event listener

You can place the code below in your config.yml-file. Make sure to replace the
data with values that reflect you event listener

```yml
services:
  #...
  kernel.listener.core_listener:
    class: SumoCoders\FrameworkXxxBundle\EventListener\SearchListener
    tags:
      - { name: kernel.event_listener, event: framework_search.search, method: onSearch }
```


