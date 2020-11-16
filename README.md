> ⚠ **REPO ARCHIVED!**  
> This litte project, I like to think, was a great idea when I started it. Today, it wouldn't make much sense to finish it, because there are far superior projects doing the [_exact same thing_](https://github.com/verless/verless) - only _much_ better.

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

## Is LOG.md a static site generator?
No. Kind of. Yes. Not really. It caches and re-uses the rendered HTML of each post (so it doesn't have to do the Markdown rendering again), but it still reads the posts meta data from your posts files headers at each call.

## Attributions
LOG.md doesn't really do anything.  
All the hard work is done by:
- **Parsedown** for Markdown parsing ([erusev/parsedown](https://github.com/erusev/parsedown))
- **php-image-resize** for image resizing ([gumlet/php-image-resize](https://github.com/gumlet/php-image-resize))
- **retro.css** for Markdown styling in sleeping-monkey default theme ([markdowncss/retro](https://github.com/markdowncss/retro))
- **github-markdown-css** for Markdown styling in github-style default theme ([sindresorhus/github-markdown-css](https://github.com/sindresorhus/github-markdown-css))