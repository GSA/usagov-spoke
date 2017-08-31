
If you're using html asset for form creation
for has to follow below rules:

1. to have recipients, path input types
2. form action needs to have following path

<form action="emailpage" method="post" accept-charset="UTF-8">

<label for="edit-recipients">Send To <span class="form-required" title="This field is required.">*</span></label>
<textarea id="edit-recipients" name="recipients" cols="50" rows="5" class="form-textarea required"></textarea><div class="grippie">

<input type="hidden" name="path" >
<input type="submit" id="edit-submit" name="op" value="Send Message" class="form-submit"</form>