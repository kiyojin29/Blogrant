<!-- Add this to your message.php file -->
<?php if ($successMessage): ?>
    <div class="success">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="error">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>
