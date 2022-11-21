# Welcome to the XWP Coding Challenge

We are really happy that you decided to apply to XWP! As part of the hiring process, this challenge helps us to evaluate your technical skills and work experience.

Take note that this code challenge has two parts: a Gutenberg challenge and a Backend challenge. **Please make sure that you only attempt the challenge(s) as directed in the email that you received from XWP.**

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

## Backend Code Challenge

This challenge tests your knowledge of security and performance in WordPress sites.

For this challenge, we want you to look primarily at the functions mentioned below, fix whatever problems you see, and make improvements to solve scaling, security, performance, and coding standards issues. There's no need to add any additional features at this stage.

### Custom WP-CLI script

Location: `\XWP\CountryCard\Modules\CLI::handle_cli_request`

The CLI script is responsible for inserting posts with test data. Each post corresponds with one of the world's largest cities with a population larger than 100,000 or 1,000,000. Each posts' content consists of two paragraphs.

The issue with this script is that it inserts paragraphs that are then treated as "classic blocks" in the Block Editor, causing a poor editorial experience. This script should be modified in a way that it inserts two paragraph blocks instead.

|Status|Screenshot|
|-|-|
|Expected|![Paragraph blocks](assets/paragraph-blocks.png?raw=true)|
|Incorrect|![Paragraph blocks](assets/classic-block.png?raw=true)|


### Block output filtering

The block output is filtered through PHP to append an additional paragraph. The appended paragraph displays a counter of all cities in a chosen country having a population larger than 100,000 or 1,000,000. There are a couple of issues related to this:

#### Cities counter

Location: `\XWP\CountryCard\Modules\Block::count_country_cities`

Data querying used inside this method is non performant and should be improved.

#### Country data extraction

Location: `\XWP\CountryCard\Modules\Block::find_country_data`

Since the `countryCode` attribute is stored inside an HTML `<abbr>` tag, its value needs to be extracted from the block output. The `countryName` value is stored as a `title` attribute of the mentioned tag.

This function uses a combination of string manipulation functions to substract these values, but this should be replaced with a more solid solution.
