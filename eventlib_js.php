<script src="js/selectutils.js"></script>
<script src="js/datevalidation.js"></script>
<script>
    var tnglitbox;
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    var tree = "<?php echo $tree; ?>";
    const entereventtype = "<?php echo _('Please select an Event Type.'); ?>";
    const entereventinfo = "<?php echo _('Please enter an Event Date, an Event Place or the Detail for this event.'); ?>";
    const confdeleteevent = "<?php echo _('Are you sure you want to delete this event?'); ?>";
    const enternote = "<?php echo _('Please enter the note text.'); ?>";
    const confdeletenote = "<?php echo _('Are you sure you want to delete this note?'); ?>";
    const selectsource = "<?php echo _('Please select a Source.'); ?>";
    const confdeletecite = "<?php echo _('Are you sure you want to delete this citation?'); ?>";
    const enterpassoc = "<?php echo _('Please enter the ID of the associated person.'); ?>";
    const enterrela = "<?php echo _('Please enter the relationship.'); ?>";
    const confdeleteassoc = "<?php echo _('Are you sure you want to delete this association?'); ?>";
    const editmsg = "<?php echo _('Edit'); ?>";
    const delmsg = "<?php echo _('Delete'); ?>";
    const notemsg = "<?php echo _('Notes'); ?>";
    const citemsg = "<?php echo _('Sources'); ?>";
</script>