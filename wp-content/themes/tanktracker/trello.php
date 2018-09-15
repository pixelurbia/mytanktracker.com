<?php
/*
Template Name: Trello
*/
?>

<?php get_template_part('templates/header'); ?>
<section class="frame page">
<article class="page">
	<h2><?php the_title(); ?></h2>
<form id="trello-form" >
	<br>
	<br>
	<br>
    <div class="form-group">
        <div class="col-md-12">
            <input type="text" name="title" placeholder="Title" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <select type="text" name="donor" value="" placeholder="Are you a donor? " class="form-control">
                    <option value="No">Are you a donor?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
        </div>

    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea name="content" cols="40" rows="10" placeholder="Content" class="form-control"></textarea>
            <?php wp_nonce_field('trello_bug_report','trello_bug_report', true, true ); ?>
			<input type="hidden" name="action" value="trello_bug_report">
        </div>
    </div>
    <div class="form-group">
        <input type="submit" value="Submit">
    </div>
</form>

</article>


</section>
<?php get_template_part('templates/footer'); ?>


