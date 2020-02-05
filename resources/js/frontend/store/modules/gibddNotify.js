export default {
    actions: {
        fillTourInfo({
            commit
        }, data) {
            commit('setTourInfo', data)
        },
        removeVehicle({
            commit
        }, vehicle) {
            commit('filterVehicles', vehicle)
        },
        addVehicle({
            commit
        }) {
            commit('newEmptyVehicle')
        },
        removeDriver({
            commit
        }, driver) {
            commit('filterDrivers', driver)
        },
        addDriver({
            commit
        }) {
            commit('newEmptyDriver')
        },
        updateStopPoints({
            commit
        }, stopPoints) {
            commit('setStopPoints', stopPoints)
        }
    },
    mutations: {
        setTourInfo(state, data) {
            state.tourInfo = data
        },
        filterVehicles(state, vehicle) {
            state.tourInfo.form4.vehicles = state.tourInfo.form4.vehicles.filter(item => item != vehicle)
        },
        newEmptyVehicle(state) {
            state.tourInfo.form4.vehicles.push({
                brand_and_model: '',
                number: '',
                diagnostic_card_info: '',
                navigator_info: true,
            })
        },
        filterDrivers(state, driver) {
            state.tourInfo.form5.drivers = state.tourInfo.form5.drivers.filter(item => item != driver)
        },
        newEmptyDriver(state) {
            state.tourInfo.form5.drivers.push({
                name: '',
                licence: '',
                licence_date: '',
                experience: ''
            })
        },
        setStopPoints(state, stopPoints) {
            state.tourInfo.form6.stopPoints = stopPoints
        }
    },
    state: {
        tourInfo: {
            regionsWithCodesArray: [{
                    value: '01',
                    text: 'Республика Адыгея'
                },
                {
                    value: '02',
                    text: 'Республика Башкортостан'
                },
                {
                    value: '03',
                    text: 'Республика Бурятия'
                },
                {
                    value: '04',
                    text: 'Республика Алтай'
                },
                {
                    value: '05',
                    text: 'Республика Дагестан'
                },
                {
                    value: '06',
                    text: 'Республика Ингушетия'
                },
                {
                    value: '07',
                    text: 'Кабардино-Балкарская Республика'
                },
                {
                    value: '08',
                    text: 'Республика Калмыкия'
                },
                {
                    value: '09',
                    text: 'Республика Карачаево-Черкессия'
                },
                {
                    value: '10',
                    text: 'Республика Карелия'
                },
                {
                    value: '11',
                    text: 'Республика Коми'
                },
                {
                    value: '12',
                    text: 'Республика Марий Эл'
                },
                {
                    value: '13',
                    text: 'Республика Мордовия'
                },
                {
                    value: '14',
                    text: 'Республика Саха (Якутия)'
                },
                {
                    value: '15',
                    text: 'Республика Северная Осетия-Алания'
                },
                {
                    value: '16',
                    text: 'Республика Татарстан'
                },
                {
                    value: '17',
                    text: 'Республика Тыва'
                },
                {
                    value: '18',
                    text: 'Удмуртская Республика'
                },
                {
                    value: '19',
                    text: 'Республика Хакасия'
                },
                {
                    value: '21',
                    text: 'Чувашская Республика'
                },
                {
                    value: '22',
                    text: 'Алтайский край'
                },
                {
                    value: '23',
                    text: 'Краснодарский край'
                },
                {
                    value: '24',
                    text: 'Красноярский край'
                },
                {
                    value: '25',
                    text: 'Приморский край'
                },
                {
                    value: '26',
                    text: 'Ставропольский край'
                },
                {
                    value: '27',
                    text: 'Хабаровский край'
                },
                {
                    value: '28',
                    text: 'Амурская область'
                },
                {
                    value: '29',
                    text: 'Архангельская область'
                },
                {
                    value: '30',
                    text: 'Астраханская область'
                },
                {
                    value: '31',
                    text: 'Белгородская область'
                },
                {
                    value: '32',
                    text: 'Брянская область'
                },
                {
                    value: '33',
                    text: 'Владимирская область'
                },
                {
                    value: '34',
                    text: 'Волгоградская область'
                },
                {
                    value: '35',
                    text: 'Вологодская область'
                },
                {
                    value: '36',
                    text: 'Воронежская область'
                },
                {
                    value: '37',
                    text: 'Ивановская область'
                },
                {
                    value: '38',
                    text: 'Иркутская область'
                },
                {
                    value: '39',
                    text: 'Калининградская область'
                },
                {
                    value: '40',
                    text: 'Калужская область'
                },
                {
                    value: '41',
                    text: 'Камчатский край'
                },
                {
                    value: '42',
                    text: 'Кемеровская область - Кузбасс'
                },
                {
                    value: '43',
                    text: 'Кировская область'
                },
                {
                    value: '44',
                    text: 'Костромская область'
                },
                {
                    value: '45',
                    text: 'Курганская область'
                },
                {
                    value: '46',
                    text: 'Курская область'
                },
                {
                    value: '47',
                    text: 'Ленинградская область'
                },
                {
                    value: '48',
                    text: 'Липецкая область'
                },
                {
                    value: '49',
                    text: 'Магаданская область'
                },
                {
                    value: '50',
                    text: 'Московская область'
                },
                {
                    value: '51',
                    text: 'Мурманская область'
                },
                {
                    value: '52',
                    text: 'Нижегородская область'
                },
                {
                    value: '53',
                    text: 'Новгородская область'
                },
                {
                    value: '54',
                    text: 'Новосибирская область'
                },
                {
                    value: '55',
                    text: 'Омская область'
                },
                {
                    value: '56',
                    text: 'Оренбургская область'
                },
                {
                    value: '57',
                    text: 'Орловская область'
                },
                {
                    value: '58',
                    text: 'Пензенская область'
                },
                {
                    value: '59',
                    text: 'Пермский край'
                },
                {
                    value: '60',
                    text: 'Псковская область'
                },
                {
                    value: '61',
                    text: 'Ростовская область'
                },
                {
                    value: '62',
                    text: 'Рязанская область'
                },
                {
                    value: '63',
                    text: 'Самарская область'
                },
                {
                    value: '64',
                    text: 'Саратовская область'
                },
                {
                    value: '65',
                    text: 'Сахалинская область'
                },
                {
                    value: '66',
                    text: 'Свердловская область'
                },
                {
                    value: '67',
                    text: 'Смоленская область'
                },
                {
                    value: '68',
                    text: 'Тамбовская область'
                },
                {
                    value: '69',
                    text: 'Тверская область'
                },
                {
                    value: '70',
                    text: 'Томская область'
                },
                {
                    value: '71',
                    text: 'Тульская область'
                },
                {
                    value: '72',
                    text: 'Тюменская область'
                },
                {
                    value: '73',
                    text: 'Ульяновская область'
                },
                {
                    value: '74',
                    text: 'Челябинская область'
                },
                {
                    value: '75',
                    text: 'Забайкальский край'
                },
                {
                    value: '76',
                    text: 'Ярославская область'
                },
                {
                    value: '77',
                    text: 'г. Москва'
                },
                {
                    value: '78',
                    text: 'г. Санкт-Петербург'
                },
                {
                    value: '79',
                    text: 'Еврейская автономная область'
                },
                {
                    value: '82',
                    text: 'Республика Крым'
                },
                {
                    value: '83',
                    text: 'Ненецкий автономный округ'
                },
                {
                    value: '86',
                    text: 'Ханты-Мансийский автономный округ - Югра'
                },
                {
                    value: '87',
                    text: 'Чукотский автономный округ'
                },
                {
                    value: '89',
                    text: 'Ямало-Ненецкий автономный округ'
                },
                {
                    value: '92',
                    text: 'г. Севастополь'
                },
                {
                    value: '95',
                    text: 'Чеченская Республика'
                },
            ],
            form1: {
                name: 'Иванов',
                position: 'Менеджер',
                phone: '322',
                email: 'dfdf@fff.fg',
                selectedRegionCodes: ['78'],
                count: 15,
                goal: 'экскурсия',
                dateStart: '2020-03-01',
                timeStart: '00:00',
                dateEnd: '2020-03-02',
                timeEnd: '00:00',
            },
            form2: {
                type: '2',
                entity_name: 'Юрлицо',
                name: 'Фио ИП1',
                entity_address: 'Московский',
                address: '254',
                entity_location: 'Подвал',
                phone: '222',
                email: 'ur@ur.ur',
                inn: '7729773587',
            },
            form3: {
                type: '3',
                entity_name: 'ип',
                name: 'ИПЭШНИК',
                entity_address: '3',
                address: 'Квартира Петрова спросить Вольнова',
                entity_location: '3111',
                phone: '555',
                email: 'ip@ip.ip',
                inn: '7729773587',
            },
            form4: {
                vehicles: [{
                        brand_and_model: 'IVECO',
                        number: 'а222аа78',
                        diagnostic_card_info: '231111m',
                        navigator_info: 1,
                    },
                    {
                        brand_and_model: 'MAN',
                        number: 'в245аа78',
                        diagnostic_card_info: '777m',
                        navigator_info: 1,
                    }
                ]
            },
            form5: {
                drivers: [{
                    name: 'Первый Водитель',
                    licence: '78РНРХПХ1232',
                    licence_date: '01.01.2000',
                    experience: 'Опыт работы работы'
                }, {
                    name: 'Второй водитель',
                    licence: '99РНРХПХ',
                    licence_date: '01.01.1999',
                    experience: 'Опыт работы2'
                }]
            },
            form6: {
                address_start: 'Начало маршрута',
                region_code: '',
                district: '',
                distance: '',
                schedule: '',
                duration: '',
                stopPoints: [],
            }
        }
    },
    getters: {
        getRegionsWithCodesArray(state) {
            return state.tourInfo.regionsWithCodesArray
        },
        getForm1(state) {
            return state.tourInfo.form1
        },
        getForm2(state) {
            return state.tourInfo.form2
        },
        getForm3(state) {
            return state.tourInfo.form3
        },
        getForm4(state) {
            return state.tourInfo.form4
        },
        getForm5(state) {
            return state.tourInfo.form5
        },
        getForm6(state) {
            return state.tourInfo.form6
        },
        getAvailableRegions(state) {
            let result = []
            state.tourInfo.form1.selectedRegionCodes.forEach((selectedRegionCode) => {
                const selectedRegion = state.tourInfo.regionsWithCodesArray.find((item) => {
                    return item.value == selectedRegionCode
                })
                if (selectedRegion) {
                    result.push(selectedRegion)
                }
            })
            return result
        }
    }
}
