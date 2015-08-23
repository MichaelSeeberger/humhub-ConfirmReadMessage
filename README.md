# humhub-ConfirmReadMessage
This is a module for HumHub that enables you to post messages that other users in the space can confirm as read.

## Features

  * Allow messages to be confirmed
  * List users that confirmed the message as read
  * List users that have not confirmed the message as read

## Installation
Copy the folder into the `<path to humhub>/protected/modules/` folder and rename it to ConfirmReadMessage. If you wish to clone it, run the following commands:

    cd <path to humhub>/protected/modules
    git clone https://github.com/MichaelSeeberger/humhub-ConfirmReadMessage.git ConfirmReadMessage

If you want to add it as submodule into an existing repository, type

    cd <path to humhub>
    git submodule add https://github.com/MichaelSeeberger/humhub-ConfirmReadMessage.git protected/modules/ConfirmReadMessage

Note: Versions previous to 1.1.2 will not work on servers that use case sensitive file systems. Make sure to get v1.1.2 or later.

## Localizations
Localizations are provided for following languages:

  * English
  * German
