MLS System For Doctrine ORM
===========================================

MLS System For Doctrine ORM is an entity based Multi Language System for Doctrine ORM. Check this example out:

    $entity->translate('en')->getName(); // equals to "Pen"
    $entity->translate('tr')->getName(); // equals to "Kalem"

##Install
* Delete old entities from models/entities/* folder.
* Change Doctrine/ORM/Tools/EntityGenerator.php with our file in the repo.
* Copy base files to models/entities/base/*
* Execute sql in your db. 
* Create new entities using Doctrine's own entity generator.
* <b>Add language records to BBR_Language table like this: </b>
<pre>id - name - name_safe - iso_code
1- Türkçe - Turkish - tr</pre>
* <b>Add translations to BBR_Translations table like this: </b>
<pre>id - table - column - row - translation - language_id
1- LypGoods (your entity's name) - name - 1 - Kalem - 1</pre>
* Change your entity class and add translation array like this:
<pre>public $translation_fields = array();</pre> to:
<pre>public $translation_fields = array('name');</pre>

## Notes
* You can add as much translatable field as you want to array.
* You <b><u>cannot</b></u> flush translation table like this: (for now)
<pre>$entity->translate('tr')->setName('Pencil');
$em->flush();</pre>

##Roadmap
* Flushing of course ;)