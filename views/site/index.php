<?php

/* @var $this yii\web\View */

$this->title = 'AvalSWB Back-end';
?>
<div>
    <h1>Backend application for AvalSWB</h1>
    <p>Author: Lucas Lopes</p>
    <p>Email: lucaslopes_@outlook.com</p>
    <p>Phone: (34) 9 9884-4236</p>
    <p>Date: 17/04/2019</p>
</div>
<div>
    <h2>System Calls</h2>
    <p>This is a list of all actions declared on this application</p>
    <?php foreach($actions as $controller => $actionsName): ?>
        <b>
            <?= str_replace('Controller', '', $controller); ?>
        </b>
        <br>
        <?php foreach($actionsName as $name): ?>
            <p style="display:inline-block;margin-left: 9px">
                <?= $name; ?>
            </p>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>
    <h2>URL Pattern</h2>
    <p>{host}/avalswb/web/{controller}/{action}</p>
</div>
