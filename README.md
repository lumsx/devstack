# Edly's Open edX + WordPress Devstack

## Introduction

This is a custom fork of Open edX's docker based development environment, frankly known as devstack. For those who want to read the original README can follow this [link](https://github.com/edx/devstack). Following instructions and guides are specific to the edly.io team.

## Prerequisites

-   Your local machine should be configured to clone from **github using SSH**. Also, you need access to edly's private repos.
-   A python virtualenv in which all the python dependencies will be installed (I recommend [virtualenvwrapper](https://virtualenvwrapper.readthedocs.io))
-   [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) 17.06+ CE

## Environment configuration

The `OPENEDX_RELEASE` variable should be set in your \*nix environment. Use the following command to set it. Currently the devstack supports `ironwood` and `hawthorn` releases of Open edX.

```
export OPENEDX_RELEASE=ironwood.master
```

OR

```
export OPENEDX_RELEASE=hawthorn.master
```

To avoid doing this everytime, add the above line to your bash or zsh profile.

## Quick Start

To get up and running as quickly as possible simply run the following commands from your \$HOME directory. These commands can take a few hours to run completely. So please keep track of the time.

```
mkdir -p edly/edX/
cd edly/edX
git clone git@github.com:edly-io/devstack.git
cd devstack
make requirements
make dev.clone
make dev.checkout
make pull
make dev.provision
```

Now to run all of the edX services simply run

```
make dev.up
```

And to stop the services

```
make stop
```

## Setting up WordPress and Open edX theme

Some WordPress related configuration has to be done manually after the devstack is setup for the first time.

1. Visit [localhost:8888](http://localhost:8888). It should prompt the WordPress installation screen.
2. Fill it in with the following values
    - Site name: Edly
    - Username: edx
    - Password: edx
    - Email: edx@example.com
3. Click `Install` and the login with the same credentials.
4. You should now be in the WordPress admin dashboard.
5. Go to `Plugins -> Installed Plugins` and activate all the plugins.
6. Go to `Appearance -> Themes` and activate `Edly WordPress Theme`
7. Enjoy.

To setup the Edly edx themes repo.

1. Go do the `edly/edX` directory.
2. Run `sudo chmod -R 777 src/`
3. Clone [edly-edx-themes](https://github.com/edly-io/edly-edx-themes) in the `src` folder.
4. Run `sudo chmod -R 777 src/`
5. Run `cd devstack`
6. Run `make lms-shell`. This will take you to the docker container for LMS.
7. Edit the `/edx/app/edxapp/lms.env.json` file in the docker container to the following values.

```json
"ENABLE_COMPREHENSIVE_THEMING": true,

"COMPREHENSIVE_THEME_DIRS": [
    "/edx/src/edly-edx-themes"
]
```

8. Run `docker-compose restart lms` in the `/edly/edX/devstack` folder.
9. Enter the LMS docker shell through `make lms-shell`. Run `paver update_assets` in the docker shell from the `/edx/app/edxapp/edx-platform` folder.
10. Exit the docker shell using `Ctrl+D`
11. Run `make lms-restart`
12. Go to `http://localhost:18000/admin` and login using `edx` and `edx`.
13. Go to `http://localhost:18000/admin/sites/site/` and add a new site with values `domain` as `localhost:18000` and `display name` as `st-lutherx`.
14. Go to `http://localhost:18000/admin/theming/sitetheme/` and add a new theme with values `site` as `localhost:18000` and `Theme dir name` as `st-lutherx`.
15. This should work.

## Service URLs

| Service               | URL                                                              |
| --------------------- | ---------------------------------------------------------------- |
| WordPress             | [http:localhost:8888](http:localhost:8888)                      |
| LMS                   | [http:localhost:18000](http:localhost:18000)                     |
| CMS / Studio          | [http:localhost:18010](http:localhost:18010)                     |
| Catalog / Discovery   | [http:localhost:18381/api-docs](http:localhost:18381/api-docs)   |
| Ecommerce / Otto      | [http:localhost:18130/dashboard](http:localhost:18130/dashboard) |
| Notes / edx-notes-api | [http:localhost:18120/api/v1](http:localhost:18120/api/v1)       |
| Credentials           | [http://localhost:18150/api/v2/](http://localhost:18150/api/v2/) |

## Explanation

The Open edX devstack runs on a number of docker containers. Each container run a specific edX service. For our own purposes, A custom WordPress container has also been added to these containers.

Let's go through the commands one-by-one.

As stated previously, please make sure that you fulfill all the prerequisites listed above.

1. First, I recommend creating a dedicated project folder for edly. A simple folder named `edly` in the home directory is fine. The reason I have also created an `edX` folder inside here is that the devstack clones the Open edX repos in its parent folder. i.e. if `edly/edX/devstack` is the path of the devstack repo then all of the code will be cloned in `edly/edX`. This is how just devstack works. So, to create the directories

```
mkdir -p /edly/edX
cd edly/edX
```

2. Next step is to clone the actual devstack repo.

```
git clone git@github.com:edly-io/devstack.git
cd devstack
```

3. Now, the first thing to do is install the python requirements for devstack. You should have a python virtualenv activated in your shell.
   Most docker commands have been aliased through the `make` interface so you shouldn't have to run `docker` and `docker-compose` commands directly.

```
make requirements
```

4. Now, we will actually clone all the repos needed to run the devstack. We have a `make` command to handle this. You should have SSH configured on your github with edly's private repo access for this to work correctly. This command can take a while since it's downloading around a dozen repositories. Grab a coffee or tea.

```
make dev.clone
```

5. Next we have to pull all the docker images to our local machine. This will take some time as well. Grab another tea.

```
make pull
```

6. The next step is to provision our local machine. This will create all the necessary database configurations and settings.

```
make dev.provision
```

7. After this, you can either start all the Open edX services including WordPress through the following command

```
make dev.up
```

8. To stop all of the services, simply run the following command

```
make stop
```
