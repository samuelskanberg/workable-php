# Workable

This is a wrapper for the Workable API.

# Manually configuration before testing

To use Workable API you need to get an [access token and know your subdomain](http://resources.workable.com/how-to-generate-an-api-access-token-for-workable). Write them down.

Then you should create via the web interface

* A job position. Also create a test candidate. Write down the [shortcode](http://resources.workable.com/add-candidates-using-api) for the job
* A job position with custom questions. Also create a test candidate. Write down the shortcode

Create a file called config.ini in the root folder with the following content

    access_token = <your access token>
    subdomain = <your subdomain>
    job1_shortcode = <the first job's shortcode>
    job_with_custom_questions_shortcode = <the second job's shortcode>

This file will be read by your test suite

# Testing

Install composer

    curl -sS https://getcomposer.org/installer | php

Install phpunit

    ./composer.phar install

Make sure you have support for curl in php

    sudo apt-get install php5-curl

Run tests

    ./vendor/bin/phpunit test/


# Resources

* [http://resources.workable.com/workable-api-documentation](http://resources.workable.com/workable-api-documentation)
* [http://resources.workable.com/add-candidates-using-api](http://resources.workable.com/add-candidates-using-api)
* [http://resources.workable.com/how-to-generate-an-api-access-token-for-workable](http://resources.workable.com/how-to-generate-an-api-access-token-for-workable)



