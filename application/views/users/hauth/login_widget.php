

<h1>Sign in</h1>

<ul>
<?php foreach ($prov as $name) : ?>
    <?php if (!isset($adapters[$name])) : ?>
        <li>
            <a href="http://localhost/onlinetraining/users/hauth/provider/<?php print $name ?>">
                Sign in with <?php print $name ?>
            </a>
        </li>
    <?php endif; ?>
<?php endforeach; ?>
</ul>
