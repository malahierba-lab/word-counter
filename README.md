# Laravel Word Counter

A tool for get information from external websites. Powered by PhantomJS and malahierba.cl dev team

## Installation

Add in your composer.json:

    {
        "require": {
            "malahierba-lab/word-counter": "0.*"
        }
    }

Then you need run the `composer update` command.

## Use

**Important**: For documentation purposes, in the examples below, always we assume than you import the library into your namespace using `use Malahierba\WordCounter;`

    $wordcounter = new WordCounter;
    
    // Load string to analize
    $wordcounter->load('some text');

    // Count all words
    $total = $wordcounter->countTotalWords();

    // Count each word
    // You receive an array with objects:
    // -> word
    // -> count
    $eachWord = $wordcounter->countEachWord();

    //example to get info for each word
    foreach ($eachWord as $item) {
        $word   = $item->word;
        $count  = $item->count;
    }
    
## Licence

This project has MIT licence. For more information please read LICENCE file.