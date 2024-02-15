  <!-- End of Main Content -->
      </div>
      </div>        

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; NUPSI 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script defer src="https://use.fontawesome.com/releases/v5.0.12/js/all.js"></script>
  <script>
    FontAwesomeConfig = { searchPseudoElements: true };
  </script>
  
  <!-- Bootstrap core JavaScript-->
    <!-- Subitens funcionar-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../js/mascaras.js"></script>

</body>

</html>
<script>
    var fileInputs = document.querySelectorAll('input[type="file"]');

fileInputs.forEach(function(fileInput) {
    fileInput.addEventListener('change', function(event) {
        var maxFileSize = 5 * 1024 * 1024; // 5 MB em bytes

        if (fileInput.files.length > 0) {
            var fileSize = fileInput.files[0].size; // Tamanho do arquivo em bytes
            if (fileSize > maxFileSize) {
                // O arquivo é maior do que 5 MB, limpar o campo
                alert('Erro: O tamanho do arquivo é maior do que o permitido (5 MB). Use o compressor de PDF no site: https://www.ilovepdf.com/pt/comprimir_pdf');
                fileInput.value = ''; 
            }
        }
    });
});
</script>