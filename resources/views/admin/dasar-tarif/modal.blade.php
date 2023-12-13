{{-- add dasar tarif --}}
<div class="modal" tabindex="-1" id="DasarTarifModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dasar Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-edit-DasarTarif" id="form-tambah-edit-DasarTarif">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Gerbang :</label>
                        <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Versi :</label>
                        <input type="text" class="form-control" name="versi" id="versi" aria-describedby="versi"
                            placeholder="Versi Tarif" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Surat Keputusan :</label>
                        <textarea type="text" class="form-control" name="sk" id="sk" placeholder="Surat Keputusan"
                            rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Waktu Berlaku :</label>
                        <input type="date" class="form-control" name="waktu" id="waktu" aria-describedby="waktu"
                            placeholder="Waktu Berlaku" required>
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


{{-- edit dasar tarif --}}
<div class="modal" tabindex="-1" id="DasarTarifModalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dasar Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-DasarTarif" id="form-edit-DasarTarif">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" id="idEdit" value="" />
                        <label for="exampleInputEmail1">Gerbang :</label>
                        <select class="form-control" id="gerbangmodalEdit" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Versi :</label>
                        <input type="text" class="form-control" name="versi" id="versiEdit" aria-describedby="versi"
                            placeholder="Versi Tarif" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Surat Keputusan :</label>
                        <textarea type="text" class="form-control" name="sk" id="skEdit" placeholder="Surat Keputusan"
                            rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Waktu Berlaku :</label>
                        <input type="date" class="form-control" name="waktu" id="waktuEdit" aria-describedby="waktu"
                            placeholder="Waktu Berlaku" required>
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