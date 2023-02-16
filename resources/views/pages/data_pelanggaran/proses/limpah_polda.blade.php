<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(1)">Sebelumnya</button>
            </div>

            <div>
                {{-- @if ($kasus->status_id > 2)
                    <button type="button" class="btn btn-info" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="75" data-number-of-steps="2" style="width: 75%;">
                    </div>
                </div>
                <a href="javascript::void(0)" onclick="getViewProcess(1)">
                    <div class="f1-step" style="width: 50%;">
                        <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                        <p>Diterima</p>
                    </div>
                </a>

                <div class="f1-step active" style="width: 50%;">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Limpah Polda</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h4>Limpah Ke Polda</h4>
        <form action="/surat-limpah-polda" method="post">
            @csrf
            <div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Polda / Sederajat</label>
                        <input type="text" class="form-control" id="polda_limpah" readonly
                            value="{{ $limpahPolda->polda->name }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Limpah</label>
                        <input type="text" class="form-control" readonly value="{{ $limpahPolda->tanggal_limpah }}">
                    </div>
                    <div class="col-lg-4">
                        <label for="exampleInputEmail1" class="form-label">Pelimpah</label>
                        <input type="text" class="form-control" readonly value="{{ $limpahPolda->user->name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="container">
                            <div class="title">
                                <h3>Isi Surat Limpah</h3>
                            </div>

                            <div id="editparent">
                                <div id="editControls">
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-default" data-role="undo" href="#"
                                            title="Undo"><i class="fa fa-undo"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="redo" href="#"
                                            title="Redo"><i class="fa fa-repeat"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-default" data-role="bold" href="#"
                                            title="Bold"><i class="fa fa-bold"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="italic" href="#"
                                            title="Italic"><i class="fa fa-italic"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="underline" href="#"
                                            title="Underline"><i class="fa fa-underline"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="strikeThrough" href="#"
                                            title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-default" data-role="indent" href="#"
                                            title="Blockquote"><i class="fa fa-indent"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#"
                                            title="Unordered List"><i class="fa fa-list-ul"></i></a>
                                        <a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#"
                                            title="Ordered List"><i class="fa fa-list-ol"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-default" data-role="h1" href="#"
                                            title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
                                        <a class="btn btn-xs btn-default" data-role="h2" href="#"
                                            title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
                                        <a class="btn btn-xs btn-default" data-role="h3" href="#"
                                            title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
                                        <a class="btn btn-xs btn-default" data-role="p" href="#"
                                            title="Paragraph"><i class="fa fa-paragraph"></i></a>
                                    </div>
                                </div>
                                <div id="editor" contenteditable>
                                    {{-- <ol>
                                        <li>Rujukan :&nbsp;<br><b>a</b>.&nbsp;Undang-Undang Nomor 2 Tahun 2022 tentang
                                            Kepolisian Negara Republik Indonesia.<br><b>b</b>.&nbsp;Peraturan Kepolisian
                                            Negara Republik Indonesia Nomor 7 Tahun 2022 tentang Kode Etik Profesi&nbsp;
                                            &nbsp; &nbsp;dan Komisi Kode Etik Polri.<br><b>c</b>.&nbsp;Peraturan Kepala
                                            Kepolisian Negara Republik Indonesia Nomor 13 Tahun 2016 tentang Pengamanan
                                            Internal di Lingkungan Polri<br><b>d</b>.&nbsp;Nota Dinas Kepala Bagian
                                            Pelayanan Pengaduan Divpropam Polri Nomor:
                                            R/ND-2766-b/XII/WAS.2.4/2022/Divpropam tanggal 16 Desember 2022 perihal
                                            pelimpahan Dumas BRIPKA JAMALUDDIN ASYARI.</li>
                                    </ol> --}}
                                    {!! $limpahPolda->isi_surat !!}
                                </div>
                                <textarea name="ticketDesc" id="editorCopy" required="required" style="display: none">
                                </textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Generate Surat
                    Limpah</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#editControls a').click(function(e) {
            e.preventDefault();
            switch ($(this).data('role')) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'p':
                    document.execCommand('formatBlock', false, $(this).data('role'));
                    break;
                default:
                    document.execCommand($(this).data('role'), false, null);
                    break;
            }

            var textval = $("#editor").html();
            $("#editorCopy").val(textval);
        });

        $("#editor").keyup(function() {
            var value = $(this).html();
            $("#editorCopy").val(value);
        }).keyup();

        $('#checkIt').click(function(e) {
            e.preventDefault();
            alert($("#editorCopy").val());
        });
    });
</script>
