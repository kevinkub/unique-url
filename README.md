Unique Url
=====

Unique Url offers you a simple way to create unique (pseudo-random) strings from
numbers (e.g. primary keys) and convert them back. The technique is based on
[linear feedback shift registers](http://en.wikipedia.org/wiki/Linear_feedback_shift_register).

Usage
-----

### Include

You need to include one file to make use of the unique url class.

    include 'kevinkub\UniqueUrl\UniqueUrl.php';
    use \kevinkub\UniqueUrl\UniqueUrl as UniqueUrl;


### Setup

It is required to setup a string length for the encoding process. Please note
that a length of *ten* is the maximum on 64-bit systems. The calculations will
take a little longer (o(n^2)) the longer the string gets.

    // new UniqueUrl(int stringLength[, int recursionFactor])
    $uniqueUrl = new UniqueUrl(4[, 111]);

The class comes with a default recursion of n^2 * 111. However if you want to
have a custom "rythm" in your codes you should change this value. A lower value
will give you results, that are closer to each other (AA, AB, AC, ...). A higher
value gives you more spreaded results but takes more computation time. However
111 has been a good value in all of my tests.

### Encoding numbers

The primary goal of this class is to encode numbers (e.g. primary keys from your dbs)
to strings and back. To do so, simply call `encode()`.

    $uniqueUrl->encode(12); // returns (for example) 'A0-j'

### Decoding strings

To decode a string back to the number which was encoded use the `decode()` function.

    $uniqueUrl->decode('A0-j'); // returns 12;

### Limits

Depending on the string length you choose, the numbers you can encode are limited
too. You can encode any number between 0 and *64^n - 1*.
PHP seems to limit the combinations to 64^10. I have not investigated into this any further,
but if you need to use this algorithm on numbers larger than 1,1529215e18-1 ... man you have other problems.
