<?php

namespace Drupal\personal_information\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a personal information.
 */
class PersonalInformation extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'personal_information';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield', /*user must type in the field*//*user can't type many characters*/
      '#title' => $this->t('Name:'), /*the title of the field*/
      '#required' => TRUE, /*required field*/
    ]; /*The name field*/
    $form['gender'] = [
      '#type' => 'radios', /*user must choose an option*/
      '#title' => ('Gender'),
      '#options' => [
        'male' => $this->t('Male'), /*option 1*/
        'female' => $this->t('Female'), /*option 2*/
        'other' => $this->t('Other'), /*option 3*/
      ],
    ]; /*Gender options*/
    $form['age'] = [
      '#type' => 'number', /*checks if user has typed a number*/
      '#title' => $this->t('Age:'),
      '#required' => TRUE,
    ]; /*The age field*/
    $form['birthdate'] = [
      '#type' => 'date', /*user must choose the date, month, year*/
      '#title' => $this->t('Birthdate'),
      '#required' => TRUE,
    ]; /*the birthdate field*/
    $form['email'] = [
      '#type' => 'email', /*checks if user has typed a string contains 1 and only 1 '@' character*/
      '#title' => $this->t('Email:'),
      '#required' => TRUE,
    ]; /*the email field*/
    $form['somethingaboutyou'] = [
      '#type' => 'textarea', /*user can type in many characters*/
      '#title' => $this->t('Something about you'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ]; /*submit button*/
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) < 2) {/*takes the length of name field's value*/
      $form_state->setErrorByName('name', $this->t('Your name is too short. Please type in your full name.'));
    } /*Minimum length of the name field = 2 characters*/
    if (strlen($form_state->getValue('name')) > 100) {
      $form_state->setErrorByName('name', $this->t('Your name is too long. Use your given name or truncated name.'));
    } /*Maximum length of the name field = 100 characters*/
    if (($form_state->getValue('age')) < 3) {
      $form_state->setErrorByName('age', $this->t('Your age is not valid. The range is from 3 to 115.'));
    } /*Minimum age = 3*/
    if (($form_state->getValue('age')) > 115) {
      $form_state->setErrorByName('age', $this->t('Your age is not valid. The range is from 3 to 115.'));
    } /*Maximum age = 115*/
    if (strlen($form_state->getValue('email')) < 6) {
      $form_state->setErrorByName('email', $this->t('The email is not vaild. It must have at least 6 characters.'));
    } /*Minimum length for email = 6 characters*/
    if (strlen($form_state->getValue('email')) > 254) {
      $form_state->setErrorByName('email', $this->t('The email is not vaild. It can only have 254 characters at most.'));
    } /*Maximum length for email = 254 characters*/
    if (2018 - ((date("Y", strtotime($form_state->getValue('birthdate'))))) != ($form_state->getValue('age'))) {
      $form_state->setErrorByName('birthdate', $this->t('The birthyear and the age are inconsistent.'));
    } /*Check if age = 2018 - birthyear*/
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('Name: ' . $form_state->getValue('name')); /*set the message -> the name field's value*/
    drupal_set_message('Gender: ' . $form_state->getValue('gender'));
    drupal_set_message('Birthdate: ' . date("d-m-Y", strtotime($form_state->getValue('birthdate')))); /*set the message -> the birthdate field's date, month, year value*/
    drupal_set_message('Email: ' . $form_state->getValue('email'));
  }

}
