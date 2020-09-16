<script type="text/javascript" src="js/selectutils.js"></script>
<script type="text/javascript" src="js/datevalidation.js"></script>
<script type="text/javascript">
    var tnglitbox;
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    var tree = "<?php echo $tree; ?>";
    const entereventtype = "<?php echo $admtext['entereventtype']; ?>";
    const entereventinfo = "<?php echo $admtext['entereventinfo']; ?>";
    const confdeleteevent = "<?php echo $admtext['confdeleteevent']; ?>";

    const enternote = "<?php echo $admtext['enternote']; ?>";
    const confdeletenote = "<?php echo $admtext['confdeletenote']; ?>";

    const selectsource = "<?php echo $admtext['selectsource']; ?>";
    const confdeletecite = "<?php echo $admtext['confdeletecite']; ?>";

    const enterpassoc = "<?php echo $admtext['enterpassoc']; ?>";
    const enterrela = "<?php echo $admtext['enterrela']; ?>";
    const confdeleteassoc = "<?php echo $admtext['confdeleteassoc']; ?>";

    const editmsg = "<?php echo $admtext['edit']; ?>";
    const delmsg = "<?php echo $admtext['text_delete']; ?>";
    const notemsg = "<?php echo $admtext['notes']; ?>";
    const citemsg = "<?php echo $admtext['sources']; ?>";
</script>