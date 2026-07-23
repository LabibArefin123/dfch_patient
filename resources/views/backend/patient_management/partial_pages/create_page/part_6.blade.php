<div class="card card-success card-outline">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-microscope mr-2"></i>

            Investigation Information

        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="form-group col-md-6">

                <label>
                    Has Investigation?
                </label>

                <select name="is_investigated" id="is_investigated" class="form-control">

                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>

                </select>

            </div>

        </div>

        <div id="investigationSection" style="display:none;">

            <div class="row">


                <div class="form-group col-md-12">

                    <label>Investigation Images</label>

                    <input type="file" class="form-control" name="investigation_images[]" multiple accept="image/*">

                </div>
                <div class="investigation-preview-container mt-3"></div>

                <div class="form-group col-md-12">

                    <label>Investigation Information</label>

                    <textarea id="investigation_information" name="investigation_information" class="form-control ckeditor"></textarea>

                </div>

            </div>

        </div>

    </div>

</div>
