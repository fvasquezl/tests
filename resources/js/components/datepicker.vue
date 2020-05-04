<div class="col-md-4">
    <b-form-group
        id="fieldset-1"
        description="Let us know your name."
        label="Enter your name"
        label-for="input-1"
    >
        <b-form-datepicker id="published_at" v-model="post.published_at" class="mb-2"></b-form-datepicker>

        <span v-if="errors.published_at" class="invalid-feedback" role="alert">
                            <strong>{{ errors.published_at[0] }}</strong>
                        </span>
    </b-form-group>
</div>
