<div class="modal" id="DaftarTarifModal"  style="overflow:hidden;">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModalTarif">Tambah Data Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="form-tambah-edit-DaftarTarif" action="#">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12">


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Gerbang :</label>
                                <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <input type="hidden" name="id" id="id" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asd1">Asal Gerbang :</label>
                                <br>
                                <select style="width: 100%" class="form-control" id="asal_gerbang" style="z-index: 1" name="asal_gerbang">
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asq">Asal Gerbang :</label>
                                <select class="form-control" id="asal_gerbang_update" name="asal_gerbang_update">
                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Dasar Tarif :</label>
                                <select class="form-control" id="dasartarifmodal" name="dasartarifmodal" required>

                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asd2">Jenis Transaksi :</label>
                                <select class="form-control" id="jenis" name="jenis">
                                    <!-- <option value="3">NORMAL</option>
                            <option value="1">KHL</option>
                            <option value="2">AGS</option> -->
                                </select>
                            </div>



                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Waktu Berlaku :</label>
                                <input type="text" class="form-control" name="waktu" id="waktu" aria-describedby="waktu"
                                    placeholder="Waktu Berlaku" required>
                            </div>
                        </div>



                        <div class="col-12 col-sm-12 mt-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="gol1-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol1-tab-pane" type="button" role="tab"
                                        aria-controls="gol1-tab-pane" aria-selected="true">Golongan 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol2-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol2-tab-pane" type="button" role="tab"
                                        aria-controls="gol2-tab-pane" aria-selected="false">Golongan 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol3-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol3-tab-pane" type="button" role="tab"
                                        aria-controls="gol3-tab-pane" aria-selected="false">Golongan 3</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol4-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol4-tab-pane" type="button" role="tab"
                                        aria-controls="gol4-tab-pane" aria-selected="false">Golongan 4</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol5-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol5-tab-pane" type="button" role="tab"
                                        aria-controls="gol5-tab-pane" aria-selected="false">Golongan 5</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="gol1-tab-pane" role="tabpanel"
                                    aria-labelledby="gol1-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 1
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol1"
                                                id="jagorawigol1" onkeyup="sum_gol(1)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 1 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol1" id="totalgol1"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>

                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(1)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor1[]" id="investor1">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor1[]"
                                            id="total_investor1">
                                    </div>
                                    <hr>

                                </div>
                                <div class="tab-pane fade show " id="gol2-tab-pane" role="tabpanel"
                                    aria-labelledby="gol2-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 2
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol2"
                                                id="jagorawigol2" onkeyup="sum_gol(2)" aria-describedby="jagorawigol2"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 2 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol2" id="totalgol2"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(2)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor2[]" id="investor2">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor2[]"
                                            id="total_investor2">
                                    </div>
                                    <hr>

                                </div>
                                <div class="tab-pane fade show " id="gol3-tab-pane" role="tabpanel"
                                    aria-labelledby="gol3-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 3
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol3"
                                                id="jagorawigol3" onkeyup="sum_gol(3)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 3 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol3" id="totalgol3"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>


                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(3)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor3[]" id="investor3">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor3[]"
                                            id="total_investor3">
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show " id="gol4-tab-pane" role="tabpanel"
                                    aria-labelledby="gol4-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 4
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol4"
                                                id="jagorawigol4" onkeyup="sum_gol(4)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 4 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol4" id="totalgol4"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(4)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor4[]" id="investor4">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor4[]"
                                            id="total_investor4">
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show " id="gol5-tab-pane" role="tabpanel"
                                    aria-labelledby="gol5-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 5
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol5"
                                                id="jagorawigol5" onkeyup="sum_gol(5)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 5 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol5" id="totalgol5"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(5)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor5[]" id="investor5">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor5[]"
                                            id="total_investor5">
                                    </div>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="DaftarTarifExitModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModalTarif">Tambah Data Tarif Exit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="form-tambah-edit-DaftarTarif" action="#">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12">


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Nama Gerbang :</label>
                                <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <input type="hidden" name="id" id="id" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asd1">Asal Gerbang :</label>
                                <br>
                                <select style="width: 100%" class="form-control" id="asal_gerbang" style="z-index: 100" name="asal_gerbang">
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asq">Asal Gerbang :</label>
                                <select class="form-control" id="asal_gerbang_update" name="asal_gerbang_update">
                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Dasar Tarif :</label>
                                <select class="form-control" id="dasartarifmodal" name="dasartarifmodal" required>

                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1" id="asd2">Jenis Transaksi :</label>
                                <select class="form-control" id="jenis" name="jenis">
                                    <!-- <option value="3">NORMAL</option>
                            <option value="1">KHL</option>
                            <option value="2">AGS</option> -->
                                </select>
                            </div>



                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Waktu Berlaku :</label>
                                <input type="text" class="form-control" name="waktu" id="waktu" aria-describedby="waktu"
                                    placeholder="Waktu Berlaku" required>
                            </div>
                        </div>



                        <div class="col-12 col-sm-12 mt-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="gol1-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol1-tab-pane" type="button" role="tab"
                                        aria-controls="gol1-tab-pane" aria-selected="true">Golongan 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol2-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol2-tab-pane" type="button" role="tab"
                                        aria-controls="gol2-tab-pane" aria-selected="false">Golongan 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol3-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol3-tab-pane" type="button" role="tab"
                                        aria-controls="gol3-tab-pane" aria-selected="false">Golongan 3</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol4-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol4-tab-pane" type="button" role="tab"
                                        aria-controls="gol4-tab-pane" aria-selected="false">Golongan 4</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="gol5-tab" data-bs-toggle="tab"
                                        data-bs-target="#gol5-tab-pane" type="button" role="tab"
                                        aria-controls="gol5-tab-pane" aria-selected="false">Golongan 5</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="gol1-tab-pane" role="tabpanel"
                                    aria-labelledby="gol1-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 1
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol1"
                                                id="jagorawigol1" onkeyup="sum_gol(1)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 1 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol1" id="totalgol1"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>

                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(1)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor1[]" id="investor1">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor1[]"
                                            id="total_investor1">
                                    </div>
                                    <hr>

                                </div>
                                <div class="tab-pane fade show " id="gol2-tab-pane" role="tabpanel"
                                    aria-labelledby="gol2-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 2
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol2"
                                                id="jagorawigol2" onkeyup="sum_gol(2)" aria-describedby="jagorawigol2"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 2 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol2" id="totalgol2"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(2)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor2[]" id="investor2">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor2[]"
                                            id="total_investor2">
                                    </div>
                                    <hr>

                                </div>
                                <div class="tab-pane fade show " id="gol3-tab-pane" role="tabpanel"
                                    aria-labelledby="gol3-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 3
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol3"
                                                id="jagorawigol3" onkeyup="sum_gol(3)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 3 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol3" id="totalgol3"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>


                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(3)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor3[]" id="investor3">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor3[]"
                                            id="total_investor3">
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show " id="gol4-tab-pane" role="tabpanel"
                                    aria-labelledby="gol4-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 4
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol4"
                                                id="jagorawigol4" onkeyup="sum_gol(4)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 4 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol4" id="totalgol4"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(4)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor4[]" id="investor4">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor4[]"
                                            id="total_investor4">
                                    </div>
                                    <hr>
                                </div>
                                <div class="tab-pane fade show " id="gol5-tab-pane" role="tabpanel"
                                    aria-labelledby="gol5-tab" tabindex="0">
                                    <b>Harga</b>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1"> Gol 5
                                            :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="jagorawigol5"
                                                id="jagorawigol5" onkeyup="sum_gol(5)" aria-describedby="waktu"
                                                placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3" for="exampleInputEmail1">Total Gol 5 :</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" name="totalgol5" id="totalgol5"
                                                aria-describedby="waktu" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <b>investor</b>
                                    <hr>

                                    <a class="btn btn-primary" href="#" onclick="tambahInvestor(5)">Tambah Investor</a>
                                    <div class="form-group mt-3">
                                        <label for="investor">investor</label>
                                        <input type="text" class="form-control" name="investor5[]" id="investor5">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="total_investor">Total investor</label>
                                        <input type="number" class="form-control" name="totalinvestor5[]"
                                            id="total_investor5">
                                    </div>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="modalDetailInvestor" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableDetailInvestor">
                        <thead>
                            <tr>
                                <td>Investor</td>
                                <td>Golongan 1</td>
                                <td>Golongan 2</td>
                                <td>Golongan 3</td>
                                <td>Golongan 4</td>
                                <td>Golongan 5</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>