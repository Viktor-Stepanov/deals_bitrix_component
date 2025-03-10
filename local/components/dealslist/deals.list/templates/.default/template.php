<?php if (!empty($arResult['DEALS'])): ?>
    <!-- Подключение локального CSS (возникли проблемы на локальном сервере) -->
    <link rel="stylesheet" href="<?= $templateFolder ?>/style.css">

    <!-- Временное подключение Bootstrap через CDN (убрать, если style.css доступен) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <div id="deals-app">
        <table class="table">
            <tr>
                <th @click="sortDeals('TITLE')">Название ▲▼</th>
                <th>Дата создания</th>
            </tr>
            <tr v-for="deal in deals" :key="deal.ID">
                <td>{{ deal.TITLE }}</td>
                <td>{{ deal.DATE_CREATE }}</td>
            </tr>
        </table>

        <div class="pagination d-flex justify-content-center gap-2">
            <a href="#" @click.prevent="prevPage" class="btn btn-secondary">&laquo; Назад</a>
            <span>{{ currentPage }} / {{ totalPages }}</span>
            <a href="#" @click.prevent="nextPage" class="btn btn-secondary">Вперед &raquo;</a>
        </div>
    </div>

    <!-- Подключаем Vue.js через CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.3/dist/vue-resource.min.js"></script>

    <script>
    // Инициализация Vue
    new Vue({
        el: '#deals-app',
        data: {
            deals: <?= json_encode(array_values($arResult['DEALS'])) ?>,
            currentPage: <?= $arResult['PAGINATION']['CURRENT_PAGE'] ?>,
            totalPages: <?= $arResult['PAGINATION']['TOTAL_PAGES'] ?>,
            sortField: 'TITLE', // Текущее поле сортировки
            sortDirection: 'ASC' // Текущее направление сортировки
        },
        methods: {
            async loadDeals(page = 1) {
                try {
                    const response = await fetch(`/api/dealslist.deals.list.get.php?page=${page}&sortField=${this.sortField}&sortDirection=${this.sortDirection}`);
                    const data = await response.json();
                    this.deals = data.deals;
                    this.currentPage = data.currentPage;
                    this.totalPages = data.totalPages;
                } catch (error) {
                    console.error('Ошибка загрузки данных:', error);
                }
            },
            sortDeals(field) {
                if (this.sortField === field) {
                    // Если поле уже выбрано, меняем направление сортировки
                    this.sortDirection = this.sortDirection === 'ASC' ? 'DESC' : 'ASC';
                } else {
                    // Выбираем новое поле для сортировки
                    this.sortField = field;
                    this.sortDirection = 'ASC';
                }
                this.loadDeals(this.currentPage); // Перезагружаем данные
            },
            prevPage() {
                if (this.currentPage > 1) {
                    this.loadDeals(this.currentPage - 1);
                }
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.loadDeals(this.currentPage + 1);
                }
            }
        },
        mounted() {
            console.log('Данные загружены:', this.deals); // Отладочный вывод
        }
    });
    </script>
<?php else: ?>
    <p>Сделок нет.</p>
<?php endif; ?>