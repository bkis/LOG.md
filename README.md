**![LOG.md](img/log.md-logo-dark-small.png)**  
  
A flat-file markdown blogging sytem so <br> primitive it's a miracle it works at all

## Actually ...
... it doesn't work, yet.

## Requirements
- PHP 5.6 or higher
- php-gd module installed (optional, needed for batch image resizing job)
- You want to write your posts in Markdown.
- You don't need more than a start page with a paginated list of your posts.
- You are motivated to make your own theme (if you don't like the default themes, which I hope you don't, because they are meant to be examples rather than aesthetic works).

## PAQs (Probably Asked Questions)
**Is LOG.md a static site generator?** No.  
**Could it be turned into one?** Yes. That would actually be a good idea, i think. A case for future-me.

## Attributions
LOG.md doesn't really do anything.  
All the hard work is done by:
- **Parsedown** for Markdown parsing ([erusev/parsedown](https://github.com/erusev/parsedown))
- **php-image-resize** for image resizing ([gumlet/php-image-resize](https://github.com/gumlet/php-image-resize))
- **retro.css** for Markdown styling in sleeping-monkey default theme ([markdowncss/retro](https://github.com/markdowncss/retro))
- **github-markdown-css** for Markdown styling in github-style default theme ([sindresorhus/github-markdown-css](https://github.com/sindresorhus/github-markdown-css))