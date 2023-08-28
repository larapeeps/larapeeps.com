## Larapeeps

An open-source directory of people who make Laravel awesome ❤️

The goal of this project is to make it easier to find and follow those who are actively contributing to the community. 

This is a community-driven project and the list can be modified by anyone who wants to add value to it.

## Adding and updating peeps

The only criteria for adding new people is that they must fit into at least one of the predefined groups.

If you think a new group should be added, please open an issue to discuss it.

This project uses a flat-file database to store the data.

There are two options for updating the list:

- You can manually edit the files in the `/content` folder
- You can clone the repository and run one of the console commands

### Adding a person
```
php artisan person:add
```

This command will prompt you for all the required fields and allow you to add a person to multiple groups

**Twitter / X integration (optional)**  
To make adding people easier, you can enable autocomplete of properties like name, website and country  
To enable this, add your Twitter API key to your .env file like this:

```
TWITTER_API_TOKEN=AAAAAAAAAAAAAAAAAAAAA...
```

https://developer.twitter.com/en/docs/twitter-api/getting-started/about-twitter-api

### Updating a person
```
php artisan person:update
```

This command will let you choose a person from the list and edit the properties as well as the groups.


### Manually editing the files

```
content/people/*.md
content/groups/*.md
```

All data is stored in these two folders. To add a new person, create a new .md file with the following format and then add their slug to appropriate groups. Make sure the slug property matches the name of the file.

```
---
name: 'Taylor Otwell'
slug: taylor-otwell
x_handle: taylorotwell
x_avatar_url: 'https://pbs.twimg.com/profile_images/1609760305763975170/Tx2TVkPI_200x200.jpg'
github_handle: taylorotwell
website_url: 'https://laravel.com'
country_code: us
---
```
