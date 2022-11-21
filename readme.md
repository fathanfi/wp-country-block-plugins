# This is part of XWP Coding Challenge

## Country Card Block

This repository contains a custom Gutenberg block called _Country Card_.
It allows the selection of a country from a list and displays basic information about that country.
If the selected country name occurs in other posts on the site, titles and excerpts of those posts will be listed in the card footer as a static list.

The design below presents two instances of the Country Card block (in a two-column layout).
The block to the right is in the _preview_ mode while the one to the left is in the _edit_ mode where a country can be selected.

![Country Card Block](screenshot.jpg?raw=true)

The block output is filtered through PHP to append an additional paragraph underneath it, which displays the counter of all cities with populations larger than 100,000 or 1,000,000 in a chosen country.

---

# Local environment

## Requirements

* [NVM](https://github.com/creationix/nvm/) - to install the correct [Node.js](https://nodejs.org/en/) version.
* [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) - to install Javascript dependencies.
* [Docker](https://www.docker.com/) - there are instructions available for installing Docker on [Windows 10 Pro](https://docs.docker.com/docker-for-windows/install/), [all other versions of Windows](https://docs.docker.com/toolbox/toolbox_install_windows/), [macOS](https://docs.docker.com/docker-for-mac/install/), and [Linux](https://docs.docker.com/v17.12/install/linux/docker-ce/ubuntu/#install-using-the-convenience-script).
* [PHP 8.0 or higher](https://www.php.net/) - there are instructions available for installing PHP on [macOS](https://www.php.net/manual/en/install.macosx.php), [Windows systems](https://www.php.net/manual/en/install.windows.php), and [Unix systems](https://www.php.net/manual/en/install.unix.php).
* [Composer](https://getcomposer.org/doc/00-intro.md) - for PHP autoloader & lint and analysis scripts.

## Installation

Since you need a WordPress environment to run the plugin, the quickest way to get up and running is to use the bundled `wp-env` environment.
Clone this repository to your local computer, `cd` to this directory, and install the required version of Node along with NPM and Composer dependencies:

```sh
nvm install
npm install
composer install
```

Then, start the local environment:

```sh
npm run env start
```

Finally, run the build process in a watch mode:

```sh
npm start
```

Now, you can access the site with the Country Card block plugin installed and activated:

[http://localhost:8888/wp-admin](http://localhost:8888/wp-admin) (Username: `admin`, Password: `password`)

In order to stop the Docker containers, run:

```sh
npm run env stop
```

If you want to clean up the database of your local WordPress instance, run:

```sh
npm run env clean all
```

### Test data insertion

You can run the CLI script included in this repository to fill your local WordPress database with 4,000+ posts. Each post corresponds with one of the world's largest cities:

```sh
npm run cli:insert-posts
```

### How to use this block?

Open the Block Editor and add the Country Card block. You can also type: `/country-card` to filter the list of blocks suggested for insertion. Then, select any country and save the post.

---

# Code Challenge

## The workflow

Fork this repo, create a feature branch, and push all of your changes there.

When you are done, issue a pull request against the `main` branch in your fork.
Let us know that your code is ready for review.

Make sure the fork is publicly accessible so that we can review it.

We will be reviewing your work in its entirety so please pay attention to the process you follow.

**Please note:** this plugin has not been used so far on any site, so you do not need to worry about a block deprecation, and you can modify the data structure as you see fit.

## Gutenberg Code Challenge

### The problem

Unfortunately, the Country Card block was not coded very well.
Apart from violating WordPress coding standards and best practices, the code is buggy and unreliable.
Moreover, the block preview does not resemble the design (see the screenshot above for reference).

### Your task

**Your task is to fix all the issues you encounter.** Since it is a Gutenberg test, you should prioritize the frontend code.

Here is what are we looking for:

- Bug-free, reliable, and clean code.
- Semantic and consistent markup and styles.
- No visual regressions.
- Codebase that sticks to the WordPress and Gutenberg coding standards and best practices.

Here is some additional information that may be helpful:

- Treat the screenshot above as the source of truth when it comes to the block design. Note that we are not expecting pixel perfection.
- It is okay for the related posts in the card footer to be static when viewed on the frontend. In this version of the block, we are not looking into making the list of posts dynamic.
- You are free to install additional dependencies, if needed.

Some of enhancement

These changes include:

**Standardize code (eslint, stylint, php)**
- Fix lint error - [08e2a3f](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/08e2a3f6c680c79d6341834203edc74a34d4716f)
- Add JSdoc, translator's comment - [2f8c846](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/2f8c84668132c067e1dbe9259855263941cb1554)

**Bug Fix**
- Block behavior that can not be edited - [91f0da0](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/91f0da0885c1ab0c1d31e8f456fae0d0f2e9a1c5)
- Related post's Excerpt that show paragraph <p tag (not sanitized) - [1140c07](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/1140c07a03553cd8cc097c4fddb54d078846dad7)
- Block validation error due to inconsistency HTML markup - [f81715f](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/f81715f01042b2a20b1838a59904c90b197fc427)

**Internationalisation**
- Add domain and use _n for singular-plural string - [6f84ca7](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/6f84ca7d8a795b40884649b54e6a1d9bbeb528fd)

**Code Refactoring**
- Create separate components folder for some content - [dd234a](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/dd234af55a2088b2321ac8241c7befafc2742835)
- Dropdown country moved to utility function's components - [28ca1dd](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/a28ca1dd6d5129162a010a81f350949979aea378)
- Add semantic HTML markup for consistency - [a543400](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/a543400bff2e17e85841442bfe5ae8f419a1b5df)
- Retieving postID with useSelect - [307ecb4](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/307ecb41debdce8a4e1d503c485f5eaba3e44f9c)

**Improvement with new Library**
- Using apiFetch library to fetch data - [5ebbe6](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/5ebbe6891ae2842fc1e7788d2cc44caeabe708b0)
- Using wordpress/notices to show notice information (error/warning/etc.) - [b067696](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/b067696826bce64db66ec54eaebad878fc111378)
- Using dompurify library to sanitized data - [1140c07](https://github.com/xwp-hiring/code-challenge--FathanFisabililah/commit/1140c07a03553cd8cc097c4fddb54d078846dad7)

**Checklist:**

- [x] No lint error or warning when perform npm run lint
- [x] No PHP error showed in log
- [x] No Js error showed in browser's console log
- [x] Page work great on different kind of devices (mobile/tablet/pc)
- [x] Has add reviewers
- [x] Has create screenshots / POC for this PR
- [x] Has been tested on local environment ex. http://localhost:8888/
- [x] There's no merge conflict when perform the PR

**Country Block Card - Screenshots Video**

https://user-images.githubusercontent.com/1131668/201037253-d7448334-3620-4b3f-a10f-04ee8df11502.mov