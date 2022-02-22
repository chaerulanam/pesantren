<div class="card">
    <div class="card-body">

        <div id="edit-mystep">
            <!-- Seller Details -->
            <h3>Data Diri</h3>
            <section>
                <form>
                    <input type="hidden" id="id">
                    <input type="hidden" id="foto-before">
                    <div class="row">

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Username</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="edit-username">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Nama
                                            Lengkap</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" placeholder="Nama Lengkap"
                                                id="edit-nama_lengkap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Sekolah
                                            Asal</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" placeholder="Sekolah Asal"
                                                id="edit-sekolah_asal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Jenis Kelamin</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-jenis_kelamin">
                                                <option value=>Select</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">NISN</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="number" placeholder="NISN" id="edit-nisn"
                                                minlength="0" maxlength="16"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="tempat_lahir" class="col-md-12 col-form-label">Tempat Lahir</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" placeholder="Tempat Lahir"
                                                id="edit-tempat_lahir">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="tanggal_lahir" class="col-md-12 col-form-label">Tanggal
                                            Lahir</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="date" value="2019-08-19"
                                                id="edit-tanggal_lahir">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">NIK (Nomor
                                            KTP)</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="number" placeholder="NIK" id="edit-nik"
                                                minlength="12" maxlength="16"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Nomor Kartu
                                            Keluarga</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="number" placeholder="No. KK"
                                                id="edit-no_kk" minlength="12" maxlength="16"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Jenjang Pendidikan</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-jenjang_pendidikan">
                                                <option value=>Select</option>
                                                <option>TK</option>
                                                <option>SD</option>
                                                <option>SMP</option>
                                                <option>SMA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Nomor HP yang
                                            Aktif</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="number" placeholder="No. HP"
                                                id="edit-no_hp" minlength="8" maxlength="13"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class=" row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="basicpill-address-input">Alamat Lengkap</label>
                                <input id="edit-alamat" class="form-control" placeholder="Jalan, Blok/Dusun, RT/RW"
                                    rows="2"></input>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <h3>Data Orang Tua</h3>
            <section>
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Nama
                                            Ayah</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" placeholder="Nama Ayah"
                                                id="edit-nama_ayah">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Pendidikan Terakhir</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-pendidikan_ayah">
                                                <option value=>Select</option>
                                                <option value="sd">SD atau Sederajat</option>
                                                <option value="smp">SMP atau Sederajat</option>
                                                <option value="sd">SMA atau Sederajat</option>
                                                <option value="diploma">Diploma</option>
                                                <option value="s1">Sarjana (S1)</option>
                                                <option value="s2">Magister (S2)</option>
                                                <option value="s3">Doktor (S3)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Penghasilan Per Bulan</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-penghasilan_ayah">
                                                <option value=>Select</option>
                                                <option>Tidak Berpenghasilan</option>
                                                <option>Kurang dari Rp 1.000.000</option>
                                                <option>Rp 1.000.000 - 2.000.000</option>
                                                <option>Rp 3.000.000 - 4.000.000</optione=>
                                                <option>Rp 4.000.000 - 5.000.000</option>
                                                <option>Lebih dari Rp 5.000.000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Pekerjaan</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-pekerjaan_ayah">
                                                <option value=>Select</option>
                                                <option>Aparatur Sipil Negara (ASN)</option>
                                                <option>TNI atau POLRI</option>
                                                <option>Anggota DPR atau DPRD</option>
                                                <option>Dokter</optione=>
                                                <option>Pedagang</option>
                                                <option>Wiraswasta</option>
                                                <option>Petani atau Nelayan</option>
                                                <option>Guru atau Dosen</option>
                                                <option>Petani atau Nelayan</option>
                                                <option>Lainya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label for="example-text-input" class="col-md-12 col-form-label">Nama
                                            Ibu</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" placeholder="Nama Ibu"
                                                id="edit-nama_ibu">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Pendidikan Terakhir</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-pendidikan_ibu">
                                                <option value=>Select</option>
                                                <option value="sd">SD atau Sederajat</option>
                                                <option value="smp">SMP atau Sederajat</option>
                                                <option value="sd">SMA atau Sederajat</option>
                                                <option value="diploma">Diploma</option>
                                                <option value="s1">Sarjana (S1)</option>
                                                <option value="s2">Magister (S2)</option>
                                                <option value="s3">Doktor (S3)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Penghasilan Per Bulan</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-penghasilan_ibu">
                                                <option value=>Select</option>
                                                <option>Tidak Berpenghasilan</option>
                                                <option>Kurang dari Rp 1.000.000</option>
                                                <option>Rp 1.000.000 - 2.000.000</option>
                                                <option>Rp 3.000.000 - 4.000.000</optione=>
                                                <option>Rp 4.000.000 - 5.000.000</option>
                                                <option>Lebih dari Rp 5.000.000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div>
                                <div class="d-flex align-items-start mt-2">
                                    <div class="mb-3 row">
                                        <label class="col-md-12 col-form-label">Pekerjaan</label>
                                        <div class="col-md-12">
                                            <select class="form-select" id="edit-pekerjaan_ibu">
                                                <option value=>Select</option>
                                                <option>Aparatur Sipil Negara (ASN)</option>
                                                <option>TNI atau POLRI</option>
                                                <option>Anggota DPR atau DPRD</option>
                                                <option>Dokter</optione=>
                                                <option>Pedagang</option>
                                                <option>Wiraswasta</option>
                                                <option>Petani atau Nelayan</option>
                                                <option>Guru atau Dosen</option>
                                                <option>Petani atau Nelayan</option>
                                                <option>Ibu Rumah Tangga atau Lainya</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>
            </section>

            <h3>Data Wali</h3>
            <section>
                <div>
                    <form>
                        <div class="row">
                            <div class="col-md-3">
                                <div>
                                    <div class="d-flex align-items-start mt-2">
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-12 col-form-label">Nama
                                                Wali</label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="text" placeholder="Nama Wali"
                                                    id="edit-nama_wali">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div>
                                    <div class="d-flex align-items-start mt-2">
                                        <div class="mb-3 row">
                                            <label class="col-md-12 col-form-label">Hubungan Sosial</label>
                                            <div class="col-md-12">
                                                <select class="form-select" id="edit-hubungan_sosial">
                                                    <option value=>Select</option>
                                                    <option>Kakek atau Nenek</option>
                                                    <option>Paman atau Bibi</option>
                                                    <option>Tetangga</option>
                                                    <option>Saudara Jauh</option>
                                                    <option>Lainya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div>
                                    <div class="d-flex align-items-start mt-2">
                                        <div class="mb-3 row">
                                            <label class="col-md-12 col-form-label">Penghasilan Per Bulan</label>
                                            <div class="col-md-12">
                                                <select class="form-select" id="edit-penghasilan_wali">
                                                    <option value=>Select</option>
                                                    <option>Tidak Berpenghasilan</option>
                                                    <option>Kurang dari Rp 1.000.000</option>
                                                    <option>Rp 1.000.000 - 2.000.000</option>
                                                    <option>Rp 3.000.000 - 4.000.000</optione=>
                                                    <option>Rp 4.000.000 - 5.000.000</option>
                                                    <option>Lebih dari Rp 5.000.000</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div>
                                    <div class="d-flex align-items-start mt-2">
                                        <div class="mb-3 row">
                                            <label class="col-md-12 col-form-label">Pekerjaan</label>
                                            <div class="col-md-12">
                                                <select class="form-select" id="edit-pekerjaan_wali">
                                                    <option value=>Select</option>
                                                    <option>Aparatur Sipil Negara (ASN)</option>
                                                    <option>TNI / POLRI</option>
                                                    <option>Anggota DPR / DPRD</option>
                                                    <option>Dokter</optione=>
                                                    <option>Pedagang</option>
                                                    <option>Wiraswasta</option>
                                                    <option>Petani / Nelayan</option>
                                                    <option>Guru/Dosen</option>
                                                    <option>Lainya / Ibu Rumah Tangga</option>
                                                    <option>Petani/Nelayan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <p>NB : Tidak Wajib Diisi ! </p>
                            </div>

                        </div>
                    </form>
                </div>
            </section>


            <h3>Finish</h3>
            <section>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                            </div>
                            <div>
                                <h5>Finish</h5>
                                <p class="text-muted">Pastikan semua data yang diisi sudah benar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <!-- end card body -->
</div>
<!-- end card -->