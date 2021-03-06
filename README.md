# PHP PMR CLI

Small utility cli tool, to store project management related info.

**PMR** is short for "Project Management Resources", but can be interpreted as an abbreviation of "Project Manager".

## Getting started

Install globally with composer:

```shell
composer global require jascha030/pmr-cli
```

## Usage

The CLI tool consists of two console commands.

### Init

Use the init command to create a `.pm.toml` resource file.

```console
pmr init
```

This will run you through a couple of questions asking if you want to add a project url for any of the following
categories:

* **Task Management**
* **Time tracking**
* **Git repo**
* **Design**

> Press enter if you want to skip a category.

### Open

The open command provides quick access to your provided resources.

```console
pmr open
```

This will give you a list of choices like demonstrated below:

```console
  Which resource are you looking for?
  [0] tasks
  [1] time
  [2] git
  [3] All
  > 
```

> Selecting 'All' (in this case 3), will open all the resource urls.

## Support

Currently, only supports Darwin (macOS) and Linux OS's. When `uname -s` is `Darwin` the CLI uses the `open` command,
for `Linux` the `xdg-open` command is executed.

## Reasoning

You might wonder...

**But Jascha, why php and not, for example, Rust?**

> My ADD mind tends to forget what it's looking for and takes long to switch between apps and sites, so this was built out of necessity.
> Because of this, I wanted this tool to be built in _hours_ instead of _days or even weeks_.

**But Jascha, why toml?**

> Never used really used it, but it looked like a better version of `yaml`, I like the human readability of yaml and because toml can be parsed in many languages easily, 
> it opens up the possibility to rebuild this app in e.g. Rust, if I ever find myself bored or wanting to practice other languages.

## TODO

* Show service name in `pmr open` choice list, instead of category key (e.g. ClickUp, Everhour etc.).
* Ask to overwrite existing `.pm.toml` config when running `pmr init` in directory with pre-existing config file.
* Add default values for services (e.g. when selecting `Everhour` as Time tracker, populate input
  with `https://app.everhour.com/`).

## License

This composer package is an open-sourced software licensed under
the [MIT License](https://github.com/jascha030/pmr/blob/master/LICENSE.md)
