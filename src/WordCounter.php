<?php
namespace Malahierba\WordCounter;

class WordCounter {

    /**
     * The active string
     *
     * @var string
     */
    protected $string;

    /**
     * The charset of the string loaded
     *
     * @var string
     */
    protected $input_charset = 'UTF-8';

    /**
     * Compare Case Sensitive
     *
     * @var string
     */
    protected $case_sensitive = false;

    /**
     * Flag for remove or not html tags
     *
     * @var string
     */
    public $remove_html_tags = true;

    /**
     * Flag for remove or not script codes
     *
     * @var string
     */
    public $remove_scripts = true;

    /**
     * Splits or not words with hyphen
     *
     * @var string
     */
    protected $hyphen_split_a_word = false;

    /**
     * Constructor de la clase
     *
     * @param   string  $string Optional.
     * @return  void
     */
    public function __construct($string = null)
    {
        $this->load($string);
    }

    /**
     * Load a string into instance
     *
     * @param   $string
     */
    public function load($string)
    {
        $this->string = $string;
    }

    /**
     * Return the number of the words founded in string
     *
     * @param   void
     * @return  integer
     */
    public function countTotalWords()
    {
        return count($this->getWordsAsArray());
    }

    /**
     * Return an array with objects (word and count)
     *
     * Each item are formed with properties:
     * - word
     * - count
     *
     * @param   void
     * @return  array
     */
    public function countEachWord()
    {
        $words = [];

        foreach ($this->getWordsAsArray() as $word_item) {

            $founded = false;

            foreach ($words as $key => $word) {
                if ($word->word == $word_item) {
                    $founded = true;
                    $words[$key]->count++;
                    break;
                }
            }

            if (! $founded) {
                $words[] = (object) ['word' => $word_item, 'count' => 1];
            }
        }

        return $words;
    }

    /**
     * Prepare string with options configurated
     *
     * @param   void
     * @return  array
     */
    public function getWordsAsArray()
    {
        $string = $this->string;

        $string = $this->getNormalizedString();

        if ($this->hyphen_split_a_word)
            preg_match_all("/[0-9\p{L}]+/u", $string, $words);
        else
            preg_match_all("/[0-9\p{L}]+(-[0-9\p{L}]+)*/u", $string, $words);

        return $words[0];

    }

    /**
     * Prepare string with options configurated
     *
     * @param   void
     * @return  string
     */
    protected function getNormalizedString()
    {
        $string = $this->string;

        if ($this->remove_scripts === true)
            $string = preg_replace('/<script[^>]*?>.*?<\/script>/is', "", $string);

        if ($this->remove_html_tags === true)
            $string = strip_tags($string);

        if ($this->case_sensitive === false)
            $string = mb_strtolower($string, $this->input_charset);

        if ($this->input_charset != 'UTF-8')
            $string = mb_convert_encoding($string, 'UTF-8', $this->input_charset);

        return $string;
    }
}
