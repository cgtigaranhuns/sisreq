<footer>
    <div class="text-center mt-6 text-sm text-gray-500">
        <p><a href="https://cgti.garanhuns.ifpe.edu.br/documentos/1/download" target="_blank"
                class="text-primary-600 hover:underline">
                📖 Manual do Usuário
            </a></p>
        <p>© {{ date('Y') }} <a href="https://cgti.garanhuns.ifpe.edu.br" target="_blank"
                class="text-primary-600 hover:underline">CGTI - IFPE Campus Garanhuns</a>. Todos os direitos
            reservados.</p>
        <p> Desenvolvido pela equipe CGTI</p>

        <!--  <p> Desenvolvido pela equipe CGTI - Versão {{ config('app.version') ?? '1.0.0' }} -
            Atualizado em
            {{ !empty(config('app.dt.version')) ? date('d/m/Y', strtotime(config('app.dt.version'))) : '01/01/2024' }} -
            Banco de Dados Versão
            {{ config('db.version') ?? '1.0.0' }} -
            Atualizado em
            {{ !empty(config('db.dt.version')) ? date('d/m/Y', strtotime(config('db.dt.version'))) : '01/01/2024' }}

        </p>-->
    </div>
</footer>