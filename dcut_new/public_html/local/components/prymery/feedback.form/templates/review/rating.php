<div class="assessment">
    <div class="assessment-title">Общая оценка товара</div>
    <div class="assessment-rating">
        <div class="rating-star">
            <?for($i=1;$i<6;$i++){?>
                <input class="ratingItem" type="radio" name="rating" id="ratingItem1_<?=$i?>" value="<?=$i?>">
                <label class="ratingLabel" data-id="1" for="ratingItem1_<?=$i?>">
                    <svg width="32" height="30" viewBox="0 0 20 19" xmlns="http://www.w3.org/2000/svg"> <path d="M10.3876 14.6279L10 14.394L9.61245 14.6279L4.95134 17.4412L6.18062 12.1394L6.28261 11.6995L5.94159 11.4036L1.82981 7.835L7.25443 7.36723L7.70405 7.32846L7.88038 6.91305L10 1.91949L12.1196 6.91305L12.296 7.32846L12.7456 7.36723L18.168 7.83481L14.0489 11.4031L13.7068 11.6995L13.8096 12.1404L15.0458 17.4394L10.3876 14.6279Z" stroke-width="1.5" /></svg>
                </label>
            <?}?>
        </div>
    </div>
</div>