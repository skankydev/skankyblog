<?php $this->setTitle('Taxonomie'); ?>
<section>
    <header>
        <h1><?= _("Taxonomies"); ?></h1>
    </header>
    <section>
        <table>
        <thead>
            <tr>
                <th><?= $this->link('tag', ['get'=>$taxonomies->sortParams('name')]);?> </th>
                <th><?= $this->link('count', ['get'=>$taxonomies->sortParams('count')]);?> </th>
                <th><?= $this->link('created', ['get'=>$taxonomies->sortParams('created')]);?> </th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($taxonomies as $tag): ?>
            <tr>
                <td><?= $tag->name;?></td>
                <td><?= $tag->count;?></td>
                <td><?= $this->Time->toHuman($tag->created); ?></td>
                <th><?= $this->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['action'=>'edit','params'=>['_id'=>$tag->_id]],['class'=>'btn-edit']);?><?= $this->link('<i class="fa fa-trash" aria-hidden="true"></i>', ['action'=>'delete','params'=>['_id'=>$tag->_id]],['class'=>'btn-trash']);?></th>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    </section>
    <footer>
        <?= $this->element('paginator',$taxonomies->getOption()); ?>
    </footer>
    <?= $this->link('Add Tag',['action'=>'add'],['class'=>'btn-default']); ?>
</section>
