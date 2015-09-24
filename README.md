# Bootgenie
A [Bootstrap](http://getbootstrap.com/) theme for [The Bug Genie](https://github.com/thebuggenie/thebuggenie). Aim is to create a visually neutral but modern and fully responsive theme which fits well with other software using Bootstrap (eg. [GitList](http://gitlist.org/)).

## Requirements
- The Bug Genie 4.0 or later (commit [e3ec660](https://github.com/thebuggenie/thebuggenie/commit/e3ec660ab724524d842022c5fbbaf3ad3f91def7) introduced the ability to override the core layout)
- An extra webserver redirect rule to serve any /assets URL from /modules/bootgenie/assets

## Roadmap
- Conversion: 
   - ✓ Convert ~~every~~ most important pages to be usable with Bootstrap
   - ✓ Strip every original JavaScript and classes (keep ids for later)
   - ✓ Insert necessary markup for Bootstrap (will be cleaned up later)
- Cleanup:
   - Replace every Bootstrap related markup with proper SCSS or JavaScript bindings
   - Maintain a wiki page with the clean markup for reference
   - Make the HTML output indent properly and nice to look at
- Specification:
   - Make a specification with the original The Bug Genie theme so every feature can be compared, checked and tested
   - Possible unit or gui testing (?)
- Enrichment:
   - Add back dynamic JavaScript features

## Why a module and not a theme?
The Bug Genie has a lot more powerful support for modules than themes. Modules support version numbering, install, upgrade, uninstall hooks and a lot more.

## License information
- If not otherwise noted: MPL 2.0 (same as [The Bug Genie 4.0](https://github.com/thebuggenie/thebuggenie))
- [Bootstrap](http://getbootstrap.com/): MIT
- [Yamm3](http://geedmo.github.io/yamm3/): MIT
