<?php
require_once '../../data/ContactData.class.php';
require_once '../../models/Contact.class.php';
/**
 */

class ContactService {
    public function __construct(){
    }

    public function getAllContactEntries() {
        $contactDataClass = new ContactData();
        $allContactDataObjects =  $contactDataClass -> readContact();
        $allContactData = array();

        foreach ($allContactDataObjects as $contactArray) {
            $contactObject = new Contact($contactArray['idContact'], $contactArray['name'], $contactArray['email'], $contactArray['description'], $contactArray['phone'], $contactArray['title']);

            array_push($allContactData, $contactObject);
        }
        return $allContactDataObjects;
    }

    public function createContactEntry($name, $email, $description, $phone, $title) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $phone = filter_var($phone, FILTER_SANITIZE_STRING);
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        //create Contact Object
        $contactDataClass = new ContactData();
        $contactDataClass -> createContact($email, $description, $phone, $title, $name);
    }

    public function updateContactEntry($idContact, $email, $description, $phone, $title, $name, $description) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $phone = filter_var($phone, FILTER_SANITIZE_STRING);
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $contactDataClass = new ContactData();
        $contactDataClass -> updateContact($idContact, $name, $email, $description, $phone, $title);
    }

    public function deleteContactEntry($idContact) {
        $idContact = filter_var($idContact, FILTER_SANITIZE_NUMBER_INT);
        if (empty($idContact) || $idContact == "") {
            return;
        } else {
            $contactDataClass = new ContactData();
            $contactDataClass -> deleteContact($idContact);
        }

    }
}