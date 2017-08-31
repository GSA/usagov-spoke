
If you want to render site index block in template, use following:

$block = module_invoke('all_childsite_misc', 'block_view', 'site_index');
        print render($block['content']);