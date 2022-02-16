    <footer class="section">
        <?php if (isset($_SESSION["user"])) {?>
            <div class="center white-text">Logged in as <?php echo $_SESSION["username"];?>.</div>
        <?php } else { ?> 
            <div class="center white-text">Not logged in.</div>
        <?php } ?>  
    </footer>

</body>
    