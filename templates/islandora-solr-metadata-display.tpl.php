<?php
/**
 * @file
 * Islandora_solr_metadata display template.
 *
 * Variables available:
 * - $solr_fields: Array of results returned from Solr for the current object
 *   based upon defined display configuration(s). The array structure is:
 *   - display_label: The defined display label corresponding to the Solr field
 *     as defined in the configuration in translatable string form.
 *   - value: An array containing all the result(s) found for the specific field
 *     in Solr for the current object when queried against Solr.
 * - $found: Boolean indicating if a Solr doc was found for the current object.
 * - $not_found_message: A string to print if there was no document found in
 *   Solr.
 *
 * @see template_preprocess_islandora_solr_metadata_display()
 * @see template_process_islandora_solr_metadata_display()
 */
//dpm( get_defined_vars() );
?>

<?php
/*****************************
 *  metadata external links  *
 *****************************/

$webservice_links = array(
	'googlescholar' => array(
		'field_name' => 'MADS_googlescholar_ms',
		'url'        => 'scholar.google.ca/citations?user=',
	),
	'mendeley' => array(
		'field_name' => 'MADS_mendeley_ms',
		'url'        => 'mendeley.com/profiles/',
	),
	'twitter' => array(
		'field_name' => 'MADS_twitter_ms',
		'url'        => 'twitter.com/',
	),
);

foreach ( $webservice_links as $webservice_link ) {
        //get the id
        $id = $solr_fields[$webservice_link['field_name']]['value'][0];
        //check to see if it is empty
        if (!empty($id)){
                //make the new link
                $new_link =  '<a href="http://' .  $webservice_link['url'] .  $id .  '">' .  $id .  '</a>';
                //reset the target var
                $solr_fields[$webservice_link['field_name']]['value'][0] = $new_link;
        }
}
$orcid_id = $solr_fields['MADS_orcid_ms']['value'][0];
if(!empty($orcid_id)) {
  $solr_fields['MADS_orcid_ms']['value'][0] = '<a href="https://orcid.org/' . $orcid_id . '">'  . "https://orcid.org/$orcid_id" . '</a>';
}
?>


<?php if ($found):
if (!(empty($solr_fields) && variable_get('islandora_solr_metadata_omit_empty_values', FALSE))):?>
<fieldset <?php $print ? print('class="islandora islandora-metadata"') : print('class="islandora islandora-metadata collapsible collapsed"');?>>
  <legend><span class="fieldset-legend"><?php print t('Details'); ?></span></legend>
  <div class="fieldset-wrapper">
	<dl xmlns:dcterms="http://purl.org/dc/terms/" class="islandora-inline-metadata islandora-metadata-fields">
	  <?php $row_field = 0; ?>
	  <?php foreach($solr_fields as $value): ?>
		<dt class="<?php print $row_field == 0 ? ' first' : ''; ?>">
		  <?php print $value['display_label']; ?>
		</dt>
		<dd class="<?php print $row_field == 0 ? ' first' : ''; ?>">
		  <?php print check_markup(implode("\n", $value['value']), 'islandora_solr_metadata_filtered_html'); ?>
		</dd>
		<?php $row_field++; ?>
	  <?php endforeach; ?>
	  <?php if (!empty($coins_url)) :?>
	  <dt class="<?php print $row_field == 0 ? ' first' : ''; ?> scholar-coins">
		  Check at UPEI
		</dt>
		<dd class="<?php print $row_field == 0 ? ' first' : ''; ?> scholar-coins-value">
		  <?php print $coins_url; ?>
		</dd>
	  <?php endif; ?>
	  <?php if (!empty($upei_scholar_views)) :?>
	  <dt class="<?php print $row_field == 0 ? ' first' : ''; ?> scholar-stats">
		  Statistics
		</dt>
		<dd class="<?php print $row_field == 0 ? ' first' : ''; ?> scholar-stats-value">
		  <?php print 'views: ' . $upei_scholar_views ; ?>
		  <?php if(!empty($upei_scholar_downloads)) print ', downloads: ' . $upei_scholar_downloads; ?>
		</dd>
	  <?php endif; ?>
	</dl>
  </div>
</fieldset>
<?php endif; ?>
<?php else: ?>
  <fieldset <?php $print ? print('class="islandora islandora-metadata"') : print('class="islandora islandora-metadata collapsible collapsed"');?>>
	<legend><span class="fieldset-legend"><?php print t('Details'); ?></span></legend>
	<?php //XXX: Hack in markup for message. ?>
	<div class="messages--warning messages warning">
	  <?php print $not_found_message; ?>
	</div>
  </fieldset>
<?php endif; ?>
<?php //pre/post-print tooltips 

//convert to lowercase
$pub_status = strtolower( $solr_fields['mods_physicalDescription_s']['value'][0] );
$preprint = '<div class="tooltip-item">
		<span class="pub_status"> Pre-print </span>
		<i class="fa fa-question-circle" aria-hidden="true"></i>
		<div class="tooltip">
			<div class="tooltip-content">
				"PRE-PRINT":<br> Authors Original Draft which is intended for Formal Publication, or already submitted for publication, but prior to the Accepted Work.
			</div>
		</div>
		</div>';
$postprint = '<div class="tooltip-item">
		<span class="pub_status"> Post-print </span>
		<i class="fa fa-question-circle" aria-hidden="true"></i>
		<div class="tooltip">
			<div class="tooltip-content">
			"POST-PRINT":<br> A version after peer review and acceptance. The Accepted Work or the Definitive Work or a Minor Revision.
			</div>
		</div>
		</div>';

if ( $pub_status == 'pre-publication' || $pub_status == 'pre-print' ) { print $preprint; } 
if ( $pub_status == 'post-publication' || $pub_status == 'post-print' ) { print $postprint; } 
?>
