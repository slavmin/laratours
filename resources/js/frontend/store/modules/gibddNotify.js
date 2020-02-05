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
            state.tourInfo.tourName = data.tour_name
            state.tourInfo.form1 = data.form1
            state.tourInfo.form2 = data.form2
            state.tourInfo.form3 = data.form3
            state.tourInfo.form4 = data.form4
            state.tourInfo.form5 = data.form5
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
                    value: 1,
                    text: 'Республика Адыгея'
                },
                {
                    value: 0,
                    text: 'Республика Башкортостан'
                },
                {
                    value: 3,
                    text: 'Республика Бурятия'
                },
                {
                    value: 4,
                    text: 'Республика Алтай'
                },
                {
                    value: 5,
                    text: 'Республика Дагестан'
                },
                {
                    value: 6,
                    text: 'Республика Ингушетия'
                },
                {
                    value: 7,
                    text: 'Кабардино-Балкарская Республика'
                },
                {
                    value: 8,
                    text: 'Республика Калмыкия'
                },
                {
                    value: 9,
                    text: 'Республика Карачаево-Черкессия'
                },
                {
                    value: 10,
                    text: 'Республика Карелия'
                },
                {
                    value: 11,
                    text: 'Республика Коми'
                },
                {
                    value: 12,
                    text: 'Республика Марий Эл'
                },
                {
                    value: 13,
                    text: 'Республика Мордовия'
                },
                {
                    value: 14,
                    text: 'Республика Саха (Якутия)'
                },
                {
                    value: 15,
                    text: 'Республика Северная Осетия-Алания'
                },
                {
                    value: 16,
                    text: 'Республика Татарстан'
                },
                {
                    value: 17,
                    text: 'Республика Тыва'
                },
                {
                    value: 18,
                    text: 'Удмуртская Республика'
                },
                {
                    value: 19,
                    text: 'Республика Хакасия'
                },
                {
                    value: 21,
                    text: 'Чувашская Республика'
                },
                {
                    value: 22,
                    text: 'Алтайский край'
                },
                {
                    value: 23,
                    text: 'Краснодарский край'
                },
                {
                    value: 24,
                    text: 'Красноярский край'
                },
                {
                    value: 25,
                    text: 'Приморский край'
                },
                {
                    value: 26,
                    text: 'Ставропольский край'
                },
                {
                    value: 27,
                    text: 'Хабаровский край'
                },
                {
                    value: 28,
                    text: 'Амурская область'
                },
                {
                    value: 29,
                    text: 'Архангельская область'
                },
                {
                    value: 30,
                    text: 'Астраханская область'
                },
                {
                    value: 31,
                    text: 'Белгородская область'
                },
                {
                    value: 32,
                    text: 'Брянская область'
                },
                {
                    value: 33,
                    text: 'Владимирская область'
                },
                {
                    value: 34,
                    text: 'Волгоградская область'
                },
                {
                    value: 35,
                    text: 'Вологодская область'
                },
                {
                    value: 36,
                    text: 'Воронежская область'
                },
                {
                    value: 37,
                    text: 'Ивановская область'
                },
                {
                    value: 38,
                    text: 'Иркутская область'
                },
                {
                    value: 39,
                    text: 'Калининградская область'
                },
                {
                    value: 40,
                    text: 'Калужская область'
                },
                {
                    value: 41,
                    text: 'Камчатский край'
                },
                {
                    value: 42,
                    text: 'Кемеровская область - Кузбасс'
                },
                {
                    value: 43,
                    text: 'Кировская область'
                },
                {
                    value: 44,
                    text: 'Костромская область'
                },
                {
                    value: 45,
                    text: 'Курганская область'
                },
                {
                    value: 46,
                    text: 'Курская область'
                },
                {
                    value: 47,
                    text: 'Ленинградская область'
                },
                {
                    value: 48,
                    text: 'Липецкая область'
                },
                {
                    value: 49,
                    text: 'Магаданская область'
                },
                {
                    value: 50,
                    text: 'Московская область'
                },
                {
                    value: 51,
                    text: 'Мурманская область'
                },
                {
                    value: 52,
                    text: 'Нижегородская область'
                },
                {
                    value: 53,
                    text: 'Новгородская область'
                },
                {
                    value: 54,
                    text: 'Новосибирская область'
                },
                {
                    value: 55,
                    text: 'Омская область'
                },
                {
                    value: 56,
                    text: 'Оренбургская область'
                },
                {
                    value: 57,
                    text: 'Орловская область'
                },
                {
                    value: 58,
                    text: 'Пензенская область'
                },
                {
                    value: 59,
                    text: 'Пермский край'
                },
                {
                    value: 60,
                    text: 'Псковская область'
                },
                {
                    value: 61,
                    text: 'Ростовская область'
                },
                {
                    value: 62,
                    text: 'Рязанская область'
                },
                {
                    value: 63,
                    text: 'Самарская область'
                },
                {
                    value: 64,
                    text: 'Саратовская область'
                },
                {
                    value: 65,
                    text: 'Сахалинская область'
                },
                {
                    value: 66,
                    text: 'Свердловская область'
                },
                {
                    value: 67,
                    text: 'Смоленская область'
                },
                {
                    value: 68,
                    text: 'Тамбовская область'
                },
                {
                    value: 69,
                    text: 'Тверская область'
                },
                {
                    value: 70,
                    text: 'Томская область'
                },
                {
                    value: 71,
                    text: 'Тульская область'
                },
                {
                    value: 72,
                    text: 'Тюменская область'
                },
                {
                    value: 73,
                    text: 'Ульяновская область'
                },
                {
                    value: 74,
                    text: 'Челябинская область'
                },
                {
                    value: 75,
                    text: 'Забайкальский край'
                },
                {
                    value: 76,
                    text: 'Ярославская область'
                },
                {
                    value: 77,
                    text: 'г. Москва'
                },
                {
                    value: 78,
                    text: 'г. Санкт-Петербург'
                },
                {
                    value: 79,
                    text: 'Еврейская автономная область'
                },
                {
                    value: 82,
                    text: 'Республика Крым'
                },
                {
                    value: 83,
                    text: 'Ненецкий автономный округ'
                },
                {
                    value: 86,
                    text: 'Ханты-Мансийский автономный округ - Югра'
                },
                {
                    value: 87,
                    text: 'Чукотский автономный округ'
                },
                {
                    value: 89,
                    text: 'Ямало-Ненецкий автономный округ'
                },
                {
                    value: 92,
                    text: 'г. Севастополь'
                },
                {
                    value: 95,
                    text: 'Чеченская Республика'
                },
            ],
            tourName: '',
            form1: {
                name: '',
                position: '',
                phone: '',
                email: '',
                selectedRegionCodes: [],
                count: 0,
                goal: '',
                dateStart: '',
                timeStart: '',
                dateEnd: '',
                timeEnd: '',
            },
            form2: {
                type: '',
                entity_name: '',
                name: '',
                entity_address: '',
                address: '',
                entity_location: '',
                phone: '',
                email: '',
                inn: '',
            },
            form3: {
                type: '',
                entity_name: '',
                name: '',
                entity_address: '',
                address: '',
                entity_location: '',
                phone: '',
                email: '',
                inn: '',
            },
            form4: {
                vehicles: [{
                        brand_and_model: '',
                        number: '',
                        diagnostic_card_info: '',
                        navigator_info: 1,
                    },
                    {
                        brand_and_model: '',
                        number: '',
                        diagnostic_card_info: '',
                        navigator_info: 1,
                    }
                ]
            },
            form5: {
                drivers: [{
                    name: '',
                    licence: '',
                    licence_date: '',
                    experience: ''
                }]
            },
            form6: {
                address_start: '',
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
        getTourNameForGibddNotify(state) {
            return state.tourInfo.tourName
        },
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
