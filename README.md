# Anasheed-Site

## Anasheed APP for IOS Devices
The official anasheed app can be found on the app store for free.

## Anasheed APP for Android (Coming Soon)
The official android app is coming soon and is in the making.

## Anasheed API Instructions
Anasheed API Consists of multiple parts:

### JSON Information Returned
The information is all returned as a string in json and will need to be parsed in order to be used.

**Full List**
"title" : stores the title of the song

**If the song is single column then it returns**
"lyrics" : stores the full length of the song

**If the song is dual column then it**
"lyrics1" : stores the left column information
"lyrics2" : stores the right column information

"switch" : stores the indication whether the song above has the 1 or 2 columns indicated using a number in string format:
either "1" or "2"

### Full Content List API
For this api the base URL is **https://anasheed.app/content.json**

Make a request to the URL above and it will return all songs stored on the site:
All content is rapped in a larger container with the main content separated by numbers and commas

Example json retrieved:
```
{
  "0":{
    // all the content goes in this section right here
    "0":{
      "title":"",
      "lyrics":"",
      "switch":""
    },
    "1":{
      "title":"",
      "lyrics1":"",
      "lyrics2":"",
      "switch":""
    }
  }
}
```


### Titles List API
For this api the base URL is **https://anasheed.app/titles.json**

Make a request to the URL above and it will return all titles of the songs stored on the site:
All Songs returned will be in a json array

Example titles json retrieved:
```
[
  "song1",
  "song2",
  "song3
]
```


### JSON Song Request API
For this api the base URL is **https://anasheed.app/requestSongapi.php?position=**

The URL above accepts 1 query at a time

Example:
```
//position of song in the json object or array position in the title json
https://anasheed.app/requestSongapi.php?position=0
```

Example json retrieved if song is 1 column:
```
{
  "lyrics":"//some song",
  "switch":"1"
}
```


Example json retrieved if song is 2 column:
```
{
  "lyrics1":"//some song lyrics left side",
  "lyrics2":"//some sone lyrics right side",
  "switch":"2"
}
```

### Questions
If anything is confusing feel free to add an issue in the issue tab to bring it to my concern,

Thank you,

### Anasheed Description and Goal
New and Old Anasheed: Written as text.

Anasheed are very important in islamic culture and is usually only left as recordings and sounds and in memory.
Thankfully, these anasheed won't be forgotten.

The Beta of the Anasheed site can be found @ ~~Anasheed.cf~~ Anasheed.app

If you feel like there is a nasheed missing than please let us know through the issue tab up above.
Or email us through the site's contact us tab.

If you are looking for a business plan for the use of these nasheeds, please contact us through the site's contact us tab

Thank you,
