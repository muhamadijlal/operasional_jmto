{{-- tambah durasi --}}
<div class="modal" tabindex="-1" id="DurasiModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Durasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-Durasi">
                    @csrf
                    <div class="form-group">
                        <label>Gerbang :</label>
                        <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="asal_gerbang">Asal Gerbang :</label>
                        <select class="form-control" name="asal_gerbang" id="asal_gerbang" required>
                            <option value="">Pilih Asal Gerbang</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol1">Durasi Gol I :</label>
                            <input type="number" min="1" class="form-control" name="gol1" id="gol1" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol2">Durasi Gol II :</label>
                            <input type="number" min="1" class="form-control" name="gol2" id="gol2" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol3">Durasi Gol III :</label>
                            <input type="number" min="1" class="form-control" name="gol3" id="gol3" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol4">Durasi Gol IV :</label>
                            <input type="number" min="1" class="form-control" name="gol4" id="gol4" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol5">Durasi Gol V :</label>
                            <input type="number" min="1" class="form-control" name="gol5" id="gol5" placeholder="0" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- edit durasi --}}
<div class="modal" tabindex="-1" id="DurasiModalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Durasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-Durasi">
                    @csrf
                    <div class="form-group">
                        <label>Gerbang :</label>
                        <select class="form-control" id="gerbangmodalEdit" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group mt-2 col-md-4">
                            <label for="asal_gerbangEdit">Kode Asal :</label>
                            <input type="text" class="form-control" name="asal_gerbang" id="asal_gerbangEdit"
                                placeholder="Kode Asal Gerbang" readonly required>
                        </div>
                        <div class="form-group mt-2 col-md-8">
                            <label for="nama_asal_gerbangEdit">Asal Gerbang :</label>
                            <input type="text" class="form-control" id="nama_asal_gerbangEdit"
                                placeholder="Nama Asal Gerbang" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol1Edit">Durasi Gol I :</label>
                            <input type="number" min="1" class="form-control" name="gol1" id="gol1Edit" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol2Edit">Durasi Gol II :</label>
                            <input type="number" min="1" class="form-control" name="gol2" id="gol2Edit" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol3Edit">Durasi Gol III :</label>
                            <input type="number" min="1" class="form-control" name="gol3" id="gol3Edit" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol4Edit">Durasi Gol IV :</label>
                            <input type="number" min="1" class="form-control" name="gol4" id="gol4Edit" placeholder="0" required>
                        </div>
                        <div class="form-group mt-2 col-md-6">
                            <label for="gol5Edit">Durasi Gol V :</label>
                            <input type="number" min="1" class="form-control" name="gol5" id="gol5Edit" placeholder="0" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
