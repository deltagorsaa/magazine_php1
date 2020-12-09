<select id="street" class="custom-form__select" name="street">
    <?php foreach ($streets as $street):?>
        <option value="<?=$street['id']?>">
            ул. <?=$street['name']?>
        </option>
    <?php endforeach?>
</select>