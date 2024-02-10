# OBELISK
Obelisk is a mock company management software, deeply integrated with the MONOLIT SSO solution developed specifically for it Created by [realmarble](https://github.com/realmarble) and [Iamax34](https://github.com/Iamax34).

## Architecture 
OBELISK uses a stack of the symfony framework as the backend, connected to the user with a frontend written in React that's held in another repository. Authentication is handled by MONOLIT which can be found [here](https://github.com/realmarble/Monolith).

## How does it work?
OBELISK's primary functionality is in Modules, Bundles which expand the base systems functionality. Modules define their routes and controllers, which are then loaded into the program allowing for quick and easy extension of functionality, provided you know what you're doing.