<?php

use DataService\Model\Metadata;
use DataService\Model\Model;
use DataService\Model\Property;

return array(
    new Model(
        new Metadata('authors'),
        array(
            new Property('firstName', 'string'),
            new Property('lastName', 'string'),
            new Property('email', 'string', null, '{firstName}.{lastName}@gmail.com'),
        )
    ),
    new Model(
        new Metadata('books', 'Library'),
        array(
            new Property('title', 'string'),
            new Property('ISBN', 'string'),
            new Property('authors', 'string'),
        )
    ),
);
