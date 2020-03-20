<?php
namespace Drupal\site_api_key\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

// This is the form we are extending
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class siteApiKeySiteInformationForm extends SiteInformationForm
{
  
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Retrieve the system.site configuration
        $site_config = $this->config('system.site');

        // Get the original form from the class we are extending
        $form = parent::buildForm($form, $form_state);

        // Add a textarea to the site information section of the form for our
        // siteapikey
        $form['site_information']['site_siteapikey'] = [
          '#type' => 'textfield',
          '#title' => t('Site API Key'),
          // The default value is the new value we added to our configuration
          // in step 1
          '#default_value' => $site_config->get('siteapikey')?$site_config->get('siteapikey'):"No API Key yet",
          //'#siteapikey' => $this->t('The siteapikey of the site'),
        ];
        $form['actions']['submit']['#value']=t('Update Configuration');
        //kint($form['actions']['submit']);die;
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Now we need to save the new siteapikey to the
        // system.site.siteapikey configuration.
        $this->config('system.site')
            // The site_siteapikey is retrieved from the submitted form values
            // and saved to the 'siteapikey' element of the system.site configuration
            ->set('siteapikey', $form_state->getValue('site_siteapikey'))
            // Make sure to save the configuration
            ->save();

        // Pass the remaining values off to the original form that we have extended,
        // so that they are also saved
        parent::submitForm($form, $form_state);
        //drupal_set_message('Site API Key has been saved with that value.'); //updating message if its require 
    }
}
?>