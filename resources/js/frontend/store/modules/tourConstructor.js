export default {
  actions: {
    async fetchAllTourOptions(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          ctx.commit('setAllTourOptions', response.data[0])
        })
        .catch(e => console.log(e))
    },
    async updateTourOptions({ commit }, options) {
      commit('setTourOptions', options)
    },
    async updateActualTransport({ commit }) {
      commit('setActualTransport')
    },
    async updateNewTransportOptions({ commit }, updData) {
      commit('setNewTransportOptions', updData)
    },
    async updateTourTransport({ commit }, transport) {
      commit('setTourTransport', transport)
    },
    async updateActualMuseum({ commit }) {
      commit('setActualMuseum')
    },
    async updateConstructorCurrentStage({ commit }, stage) {
      commit('setConstructorCurrentStage', stage)
    },
    async updateNewMuseumOptions({ commit }, updData) {
      commit('setNewMuseumOptions', updData) // Toggle museum objectable 'selected'
    },
    async upateNewMuseumCustomOrder({ commit }, updData) {
      commit('setNewMuseumCustomOrder', updData)
    },
    async updateTourMuseum({ commit }) {
      commit('setTourMuseum')
    },
    async updateActualHotel({ commit }) {
      commit('setActualHotel')
    },
    async updateNewHotelOptions({ commit }, updData) {
      commit('setNewHotelOptions', updData) // Toggle hotel objectable 'selected'
    },
    async updateTourHotel({ commit }) {
      commit('setTourHotel')
    },
    async updateActualMeal({ commit }) {
      commit('setActualMeal')
    },
    async updateTourMeal({ commit }) {
      commit('setTourMeal')
      commit('setTourAlternativeMeal')
    },
    async updateActualGuide({ commit }) {
      commit('setActualGuide')
    },
    async updateNewMealOptions({ commit }, updData) {
      commit('setNewMealOptions', updData) //Toggle meal objectable 'selected'
    },
    async updateNewGuideOptions({ commit }, updGuide) {
      commit('setNewGuideOptions', updGuide) // Toggle guide 'selected'
    },
    async updateTourGuide({ commit }) {
      commit('setTourGuide')
    },
    async updateActualAttendant({ commit }) {
      commit('setActualAttendant')
    },
    async updateNewAttendantOptions({ commit }, updAttendant) {
      commit('setNewAttendantOptions', updAttendant) // Toggle attendant 'selected'
    },
    async updateTourAttendant({ commit }) {
      commit('setTourAttendant')
    },
    async updateCustomPrice({ commit }, customPrice) {
      commit('setCustomPrice', customPrice)
    },
    async removeCustomPrice({ commit }, customPriceId) {
      commit('delCustomPrice', customPriceId)
    },
    async updateEditorsContent({ commit }, content) {
      commit('setEditorsContent', content)
    },
    async updateMuseumInEditMode({ commit }, updData) {
      commit('setMuseumInEditMode', updData)
    },
    async updateTourName({ commit }, name) {
      commit('setTourName', name)
    },
    async updateTourTotalPrice({ commit }) {
      commit('calculateTourTotalPrice')
    },
    async updateTourCorrectedPrice({ commit }) {
      commit('calculateTourCorrectedPrice')
    },
    async updateTourCommissionPrice({ commit }) {
      commit('calculateTourCommissionPrice')
    },
    async updateCorrectionToAll({ commit }, correction) {
      commit('setCorrectionToAll', correction)
    },
    async updateCorrectedPriceValues({ commit }) {
      commit('setCorrectedPriceValues')
    },
    async updateEditTour({ commit }, tour) {
      commit('setEditTour', tour)
    },
    async updateCurrentCustomerType({ commit }, value) {
      commit('setCurrentCustomerType', value)
    },
    async generateTourCalcCustomerTypes({ commit }, customerTypes) {
      commit('setTourCalcCustomerTypes', customerTypes)
    },
    async updateCommissiontoAll({ commit }, commission) {
      commit('setCommissionToAll', commission)
    },
    async updateCommissionPriceValues({ commit }) {
      commit('setCommissionPriceValues')
    },
    async clearStore({ commit }) {
      commit('reset')
    },
    async updateTourStaff({ commit }) {
      commit('setTourStaff')
    },
    async updateFreeAdlsOptions({ commit }, updData) {
      commit('setFreeAdlsOptions', updData)
    },
    async updateTourFreeAdls({ commit }) {
      commit('setTourFreeAdls')
    },
    async updateManualCommissionPriceValues({ commit }, commissionValue) {
      commit('setManualCommissionPriceValues', commissionValue)
    },
    async updateManualCommissionMode({ commit }, flag) {
      commit('setManualCommissionMode', flag)
    },
    async updateCanSave({ commit }, flag) {
      commit('setCanSave', flag)
    }
  },
  mutations: {
    setAllTourOptions(state, tourOptions) {
      state.tourOptions = tourOptions
    },
    setTourOptions(state, options) {
      state.tour.options = options
    },
    setActualTransport(state) {
      let result = []
      if (state.tourOptions.transport_options != undefined) {
          state.tourOptions.transport_options.map((item) => {
            if (state.tour.options.cities.indexOf(parseInt(item.city_id)) != -1) {
              result.push(item)
            }
          }
        )
      }
      result.forEach((transport) => {
        transport.objectables.forEach((obj) => {
          obj.selected = false
          obj.duration = {
            hours: 0,
            kilometers: 0,
            show: true,
          }
          obj.manualPrice = 0
        })
      })
      state.actualTransport = result
      state.tour.transport.forEach((selectedTransport) => {
        state.actualTransport.forEach((actualTransport) => {
          actualTransport.objectables.forEach((obj) => {
            if (obj.id == selectedTransport.obj.id) {
              obj.day = selectedTransport.obj.day
              obj.daysArray = selectedTransport.obj.daysArray
              obj.duration = selectedTransport.obj.duration
              obj.drivers = selectedTransport.obj.drivers
              obj.manualPrice = selectedTransport.obj.manualPrice
              obj.price = selectedTransport.obj.price
              obj.selected = selectedTransport.obj.selected
            }
          })
        })
      })
    },
    setNewTransportOptions: (state, updData) => {
      let updTransport = updData.company
      let updItem = {
        ...updData.item,
        drivers: updData.drivers,
      }
      let itemIndex = updTransport.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updTransport.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualTransport.findIndex(transport => transport.id == updTransport.id)
      if (index != -1) {
        state.actualTransport.splice(index, 1, updTransport)
      }
    }, 
    setTourTransport(state) {
      state.tour.transport = []
      state.tour.options.drivers = []
      state.actualTransport.forEach((transport) => {
        transport.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.transport.push({ 
              transport, 
              obj,
              correction: 0,
              commission: 0,
              correctedPrice: 0,
              commissionPrice: 0,
              pricePerSeat: parseInt(obj.price / state.tour.qnt),
              commissionPricePerSeat: 0,
              correctedPricePerSeat: 0,
            })
            if (obj.drivers) {
              obj.drivers.forEach((driver, n) => {
                let result = {
                  busName: obj.name,
                  driver: n + 1,
                  hotel: undefined,
                  meal: undefined,
                  correction: 0,
                  commission: 0,
                  correctedPricePerSeat: 0,
                  commissionPricePerSeat: 0,
                  showDetails: false,
                }
                if (driver.hotel) {
                  result.hotel = {
                    daysArray: obj.daysArray,
                  }
                }
                if (driver.meal) {
                  result.meal = {
                    daysArray: obj.daysArray,
                  }
                }
                state.tour.options.drivers.push(result)
              })
            }
          }
        })
      })
    },
    setConstructorCurrentStage(state, stage) {
      state.constructorCurrentStage = stage
    },
    setActualMuseum(state) {
      let result = []
      state.tourOptions.museum_options.map((museum) => {
          if (state.tour.options.cities.indexOf(parseInt(museum.city_id)) != -1) {
            result.push({
              ...museum
            })
          }
        }
      )
      result.forEach((museum) => {
          museum.objectables.forEach((obj) => {
            obj.selected = false
          })
        }
      )
      state.actualMuseum = result
      state.tour.museum.forEach((selectedMuseum) => {
        state.actualMuseum.forEach((actualMuseum) => {
          actualMuseum.objectables.forEach((obj) => {
            if (obj.id == selectedMuseum.obj.id) {
              obj.day = selectedMuseum.obj.day
              obj.price = selectedMuseum.obj.price
              obj.selected = selectedMuseum.obj.selected
            }
          })
        })
      })
      state.tour.museumCustomOrder.forEach((selectedMuseumCustomOrder) => {
        state.actualMuseum.forEach((actualMuseum) => {
          actualMuseum.objectables.forEach((obj) => {
            if (obj.id == selectedMuseumCustomOrder.obj.id) {
              obj.day = selectedMuseumCustomOrder.obj.day
              obj.selected = selectedMuseumCustomOrder.obj.selected
            }
          })
        })
      })
    },
    setNewMuseumOptions: (state, updData) => {
      let updMuseum = updData.museum
      let updItem = updData.item
      let itemIndex = updMuseum.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updMuseum.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualMuseum.findIndex(museum => museum.id == updMuseum.id)
      if (index != -1) {
        state.actualMuseum.splice(index, 1, updMuseum)
      }
    },
    setTourMuseum: (state) => {
      state.tour.museum = []
      state.tour.museumCustomOrder = []
      state.actualMuseum.forEach((museum) => {
        museum.objectables.forEach((obj) => {
          if (obj.selected) {
            if (!JSON.parse(obj.extra).isCustomOrder) {
              state.tour.museum.push({ 
                museum, 
                obj,
                correction: 0,
                commission: 0,
                correctedPrice: 0, 
                commissionPrice: 0,
              })
            }
            if (JSON.parse(obj.extra).isCustomOrder) {
              if (!obj.count) obj.count = 1
              let pricePerSeat = JSON.parse(obj.extra).price * obj.count / state.tour.qnt
              if (pricePerSeat) pricePerSeat = pricePerSeat.toFixed(2)
              state.tour.museumCustomOrder.push({
                museum, 
                obj,
                correction: 0,
                commission: 0,
                correctedPrice: 0, 
                commissionPrice: 0,
                pricePerSeat: pricePerSeat,
              })
            }
          }
        })
      })
    },
    setActualHotel(state) {
      let result = []
      state.tourOptions.hotel_options.map((hotel) => {
          if (state.tour.options.cities.indexOf(parseInt(hotel.city_id)) != -1) {
            result.push({
              ...hotel
            })
          }
        }
      )
      result.forEach((hotel) => {
          hotel.objectables.forEach((obj) => {
            obj.selected = false
            obj.day = 0
            obj.roomsCount = NaN
          })
        }
      )
      state.actualHotel = result
      state.tour.hotel.forEach((selectedHotel) => {
        state.actualHotel.forEach((actualHotel) => {
          actualHotel.objectables.forEach((obj) => {
            if (obj.id == selectedHotel.obj.id) {
              obj.day = selectedHotel.obj.day
              obj.daysArray = selectedHotel.obj.daysArray
              obj.totalPrice = selectedHotel.obj.totalPrice
              obj.selected = selectedHotel.obj.selected
            }
          })
        })
      })
    },
    setNewHotelOptions: (state, updData) => {
      let updHotel = updData.hotel
      let updItem = updData.item
      let about = updData.about
      let itemIndex = updHotel.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updHotel.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualHotel.findIndex(hotel => hotel.id == updHotel.id)
      if (index != -1) {
        state.actualHotel.splice(index, 1, updHotel)
      }
    }, 
    setTourHotel: (state) => {
      state.tour.hotel = []
      state.actualHotel.forEach((hotel) => {
        hotel.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.hotel.push({ 
              hotel, 
              obj,
              correction: 0,
              commission: 0,
              correctedPrice: 0, 
              commissionPrice: 0,
            })
          }
        })
      })
    },
    setActualMeal(state) {
      let result = []
      state.tourOptions.meal_options.map((meal) => {
          if (state.tour.options.cities.indexOf(parseInt(meal.city_id)) != -1) {
            result.push({
              ...meal
            })
          }
        }
      )
      result.forEach((meal) => {
          meal.objectables.forEach((obj) => {
            obj.selected = false
          })
        }
      )
      state.actualMeal = result
      state.tour.meal.forEach((selectedMeal) => {
        state.actualMeal.forEach((actualMeal) => {
          actualMeal.objectables.forEach((obj) => {
            if (obj.id == selectedMeal.obj.id) {
              obj.day = selectedMeal.obj.day
              obj.daysArray = selectedMeal.obj.daysArray
              obj.totalPrice = selectedMeal.obj.totalPrice
              obj.selected = selectedMeal.obj.selected
            }
          })
        })
      })
    },
    setNewMealOptions(state, updData) {
      let updMeal = updData.meal
      let updItem = updData.item
      let about = updData.about
      let itemIndex = updMeal.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updMeal.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualMeal.findIndex(meal => meal.id == updMeal.id)
      if (index != -1) {
        state.actualMeal.splice(index, 1, updMeal)
      }
    },
    setTourMeal(state) {
      state.tour.meal = []
      state.actualMeal.forEach((meal) => {
        meal.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.meal.push({ 
              meal, 
              obj,
              correction: 0,
              commission: 0,
              correctedPrice: 0, 
              commissionPrice: 0,
            })
          }
        })
      })
    },
    setTourAlternativeMeal(state) {
      if (state.tour.meal != []) {
        state.tour.meal.forEach((meal) => {
          meal.alternativeObj = []
          const actualMealById = state.actualMeal.find((item) => item.id == meal.meal.id)
          actualMealById.objectables.forEach((obj) => {
            if (!obj.selected) meal.alternativeObj.push(obj)
          })
        })
      }
    },
    setActualGuide(state) {
      let result = []
      state.tourOptions.guide_options.map((guide) => {
        let guideCity = JSON.parse(guide.extra).city
          if (_.intersection(guideCity, state.tour.options.cities) != []) {
            result.push({
              ...guide,
              selected: false,
              events: [],
              options: {
                hotel: false,
                meal: false,
                correction: 0,
                commission: 0,
                correctedPricePerSeat: 0,
                commissionPricePerSeat: 0,
              },
              day: NaN,
              duration: NaN,
              totalPrice: 0,
            })
          }
        }
      )
      state.actualGuide = result
      state.tour.guide.forEach((selectedGuide) => {
        state.actualGuide.forEach((actualGuide) => {
          if (actualGuide.id == selectedGuide.guide.id) {
            console.log(selectedGuide)
            actualGuide.day = selectedGuide.guide.day
            actualGuide.daysArray = selectedGuide.guide.daysArray
            actualGuide.events = selectedGuide.guide.events
            actualGuide.options = selectedGuide.guide.options
            actualGuide.totalPrice = selectedGuide.guide.totalPrice
            actualGuide.selected = selectedGuide.guide.selected
          }
        })
      })
    },
    setNewGuideOptions: (state, updGuide) => {
      const index = state.actualGuide.findIndex(guide => guide.id == updGuide.id)
      if (index != -1) {
        state.actualGuide.splice(index, 1, updGuide)
      }
      console.log(state.actualGuide[index])
    },  
    setTourGuide: (state) => {
      state.tour.guide = []
      state.actualGuide.forEach((guide) => {
        if (guide.selected) {
          state.tour.guide.push({
            guide,
            correction: 0,
            commission: 0,
            correctedPrice: 0,
            commissionPrice: 0,
            pricePerSeat: parseInt(guide.totalPrice / state.tour.qnt),
            correctedPricePerSeat: 0,
            commissionPricePerSeat: 0,
            showDetails: false,
          })
        }
      })
    },
    setActualAttendant(state) {
      let result = []
      state.tourOptions.attendant_options.map((attendant) => {
        let attendantCity = JSON.parse(attendant.extra).city
        if (_.intersection(attendantCity, state.tour.options.cities) != []) {
          result.push({
            ...attendant,
            selected: false,
            events: [],
            options: {
              hotel: false,
              meal: false,
              correction: 0,
              commission: 0,
              correctedPricePerSeat: 0,
              commissionPricePerSeat: 0,
            },
            day: NaN,
            duration: NaN,
            about: '',
            totalPrice: 0,
          })
        }
        }
      )
      state.actualAttendant = result
      state.tour.attendant.forEach((selectedAttendant) => {
        state.actualAttendant.forEach((actualAttendant) => {
          if (actualAttendant.id == selectedAttendant.attendant.id) {
            actualAttendant.day = selectedAttendant.attendant.day
            actualAttendant.daysArray = selectedAttendant.attendant.daysArray
            actualAttendant.events = selectedAttendant.attendant.events
            actualAttendant.options = selectedAttendant.attendant.options
            actualAttendant.totalPrice = selectedAttendant.attendant.totalPrice
            actualAttendant.selected = selectedAttendant.attendant.selected
          }
        })
      })
    },
    setNewAttendantOptions: (state, updAttendant) => {
      const index = state.actualAttendant.findIndex(attendant => attendant.id == updAttendant.id)
      if (index != -1) {
        state.actualAttendant.splice(index, 1, updAttendant)
      }
    },   
    setTourAttendant: (state) => {
      state.tour.attendant = []
      state.actualAttendant.forEach((attendant) => {
        if (attendant.selected) {
          state.tour.attendant.push({
            attendant,
            correction: 0,
            commission: 0,
            correctedPrice: 0,
            commissionPrice: 0,
            pricePerSeat: parseInt(attendant.totalPrice / state.tour.qnt),
            correctedPricePerSeat: 0,
            commissionPricePerSeat: 0,
            showDetails: false,
          })
        }
      })
    },
    setCustomPrice: (state, price) => {
      state.tour.customPrice.push({
        ...price,
        id: state.tour.customPrice.length,
        correction: 0,
        commission: 0,
        correctedPrice: 0,
        commissionPrice: 0,
        pricePerSeat: parseInt(price.value / state.tour.qnt),
        correctedPricePerSeat: 0,
        commissionPricePerSeat: 0,
      })
    },
    delCustomPrice(state, customPriceId) {
      state.tour.customPrice = state.tour.customPrice.filter((item) => {
        return item.id != customPriceId
      })
    },
    setTourStaff(state) {
      state.staffErrors = {
        noHotel: [],
        noMeal: [],
        show: false,
      }
      state.tour.options.drivers.forEach((driver) => {
        if (driver.hotel) {
          driver.hotelPrice = []
          driver.hotel.daysArray.forEach((driverDay) => {
            let hotelDay = {}
            state.tour.hotel.forEach((hotel) => {
              if (hotel.obj.daysArray.find(day => day == driverDay)) {
                hotelDay = hotel
              }
            })
            if (_.isEqual(hotelDay, {})) {
              state.staffErrors.noHotel.push({
                name: 'Водитель ' + driver.driver,
                day: driverDay,
              })
              state.staffErrors.show = true
            }
            else {
              driver.hotelPrice.push({
                day: driverDay,
                hotelName: hotelDay.hotel.name,
                roomName: hotelDay.obj.name,
                hotelStdPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.std,
                hotelSnglPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.sngl,
              })
            }
          })
        }
        if (driver.meal) {
          driver.mealPrice = []
          driver.meal.daysArray.forEach((driverDay) => {
            let mealDay = {}
            state.tour.meal.forEach((meal) => {
              if (meal.obj.daysArray.find(day => day == driverDay)) {
                mealDay = meal
              }
              if (!_.isEqual(mealDay, {})) {
                driver.mealPrice.push({
                  day: driverDay,
                  mealName: `${mealDay.meal.name}: ${mealDay.obj.name}`,
                  mealPrice: mealDay.obj.price,
                })
              }
            })
            // If no meal in all tour.mealArray add error
            if (_.isEqual(mealDay, {})) {
              state.staffErrors.noMeal.push({
                name: 'Водитель ' + driver.driver,
                day: driverDay,
              })
              console.log('Водитель. Нет питания.', state)
              state.staffErrors.show = true
            }
            // Remove duplicates
            driver.mealPrice = _.uniqWith(driver.mealPrice, _.isEqual)
          })
        }
      })
      state.tour.options.drivers.forEach((driver) => {
        let total = 0
        if (driver.hotelPrice) {
          driver.hotelPrice.forEach(room => total += parseFloat(room.hotelStdPrice))
        }
        if (driver.mealPrice) {
          driver.mealPrice.forEach(meal => total += parseFloat(meal.mealPrice))
        }
        driver.totalPrice = parseFloat(total)
        driver.totalPricePerSeat = parseFloat((total / state.tour.qnt).toFixed(2))
        driver.correctedPrice = total
        driver.commissionPrice = total
      })
      // Guide options
      state.tour.guide.forEach((guide) => {
        if (guide.guide.options.hotel) {
          guide.hotelPrice = []
          guide.guide.daysArray.forEach((guideDay) => {
            let hotelDay = {}
            state.tour.hotel.forEach((hotel) => {
              if (hotel.obj.daysArray.find(day => day == guideDay)) {
                hotelDay = hotel
              }
            })
            if (_.isEqual(hotelDay, {})) {
              state.staffErrors.noHotel.push({
                name: 'Гид: ' + guide.guide.name,
                day: guideDay,
              })
              state.staffErrors.show = true
            } else {
              guide.hotelPrice.push({
                day: guideDay,
                hotelName: hotelDay.hotel.name,
                roomName: hotelDay.obj.name,
                hotelStdPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.std,
                hotelSnglPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.sngl,
              })
            }
          })
        }
        if (guide.guide.options.meal) {
          guide.mealPrice = []
          guide.guide.daysArray.forEach((guideDay) => {
            let mealDay = {}
            state.tour.meal.forEach((meal) => {
              if (meal.obj.daysArray.find(day => day == guideDay)) {
                mealDay = meal
              }
              if (!_.isEqual(mealDay, {})){
                console.log('push meal: ', mealDay, guideDay)
                guide.mealPrice.push({
                  day: guideDay,
                  mealName: `${mealDay.meal.name}: ${mealDay.obj.name}`,
                  mealPrice: mealDay.obj.price,
                })
              }
            })
            // If no meal in all tour.mealArray add error
            if (_.isEqual(mealDay, {})) {
              state.staffErrors.noMeal.push({
                name: 'Гид: ' + guide.guide.name,
                day: guideDay,
              }) 
              console.log('Гид. Нет питания.', state)
              state.staffErrors.show = true
            } 
            // Remove duplicates
            guide.mealPrice = _.uniqWith(guide.mealPrice, _.isEqual)
          })
        }
        state.tour.guide.forEach((guide) => {
          let total = 0
          if (guide.hotelPrice) {
            guide.hotelPrice.forEach(room => total += parseFloat(room.hotelStdPrice))
          }
          if (guide.mealPrice) {
            guide.mealPrice.forEach(meal => total += parseFloat(meal.mealPrice))
          }
          if (guide.guide.events.length > 0) {
            guide.guide.events.forEach(event => total += parseFloat(event.price))
          }
          guide.guide.options.totalPrice = total
          guide.guide.options.totalPricePerSeat = parseFloat((total / state.tour.qnt).toFixed(2))
          guide.guide.options.correctedPrice = total
          guide.guide.options.commissionPrice = total
        })
        // Attendant options
        state.tour.attendant.forEach((attendant) => {
          if (attendant.attendant.options.hotel) {
            attendant.hotelPrice = []
            attendant.attendant.daysArray.forEach((attendantDay) => {
              let hotelDay = {}
              state.tour.hotel.forEach((hotel) => {
                if (hotel.obj.daysArray.find(day => day == attendantDay)) {
                  hotelDay = hotel
                }
              })
              if (_.isEqual(hotelDay, {})) {
                state.staffErrors.noHotel.push({
                  name: 'Сопровождающий: ' + attendant.attendant.name,
                  day: attendantDay,
                })
                state.staffErrors.show = true
              } else {
                attendant.hotelPrice.push({
                  day: attendantDay,
                  hotelName: hotelDay.hotel.name,
                  roomName: hotelDay.obj.name,
                  hotelStdPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.std,
                  hotelSnglPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.sngl,
                })
              }
            })
          }
          if (attendant.attendant.options.meal) {
            attendant.mealPrice = []
            attendant.attendant.daysArray.forEach((attendantDay) => {
              let mealDay = {}
              state.tour.meal.forEach((meal) => {
                if (meal.obj.daysArray.find(day => day == attendantDay)) {
                  mealDay = meal
                }
                if (!_.isEqual(mealDay, {})) {
                  attendant.mealPrice.push({
                    day: attendantDay,
                    mealName: `${mealDay.meal.name}: ${mealDay.obj.name}`,
                    mealPrice: mealDay.obj.price,
                  })
                }
              })
              // If no meal in all tour.mealArray add error
              if (_.isEqual(mealDay, {})) {
                state.staffErrors.noMeal.push({
                  name: 'Сопровождающий: ' + attendant.attendant.name,
                  day: attendantDay,
                }) 
                console.log('Соп. Нет питания.', state)
                state.staffErrors.show = true
              } 
              // Remove duplicates
              attendant.mealPrice = _.uniqWith(attendant.mealPrice, _.isEqual)
            })
          }
          state.tour.attendant.forEach((attendant) => {
            let total = 0
            if (attendant.hotelPrice) {
              attendant.hotelPrice.forEach(room => total += parseFloat(room.hotelStdPrice))
            }
            if (attendant.mealPrice) {
              attendant.mealPrice.forEach(meal => total += parseFloat(meal.mealPrice))
            }
            if (attendant.attendant.events.length > 0) {
              attendant.attendant.events.forEach(event => total += parseFloat(event.price))
            }
            attendant.attendant.options.totalPrice = total
            attendant.attendant.options.totalPricePerSeat = parseFloat((total / state.tour.qnt).toFixed(2))
            attendant.attendant.options.correctedPrice = total
            attendant.attendant.options.commissionPrice = total
          })
        })
      })
    },
    setTourFreeAdls(state) {
      state.freeAdlErrors = {
        noHotel: [],
        noMeal: [],
        show: false,
      }
      // FreeAdl options
      state.tour.options.freeAdls.forEach((freeAdl) => {
        if (freeAdl.options.hotel) {
          freeAdl.hotelPrice = []
          freeAdl.daysArray.forEach((freeAdlDay) => {
            let hotelDay = {}
            state.tour.hotel.forEach((hotel) => {
              if (hotel.obj.daysArray.find(day => day == freeAdlDay)) {
                hotelDay = hotel
              }
            })
            if (_.isEqual(hotelDay, {})) {
              state.freeAdlErrors.noHotel.push({
                name: '"Бесплатный взрослый": ' + freeAdl.name,
                day: freeAdlDay,
              })
              state.freeAdlErrors.show = true
            } else {
              freeAdl.hotelPrice.push({
                day: freeAdlDay,
                hotelName: hotelDay.hotel.name,
                roomName: hotelDay.obj.name,
                hotelStdPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.std,
                hotelSnglPrice: JSON.parse(hotelDay.obj.extra).priceList.adl.sngl,
              })
            }
          })
        }
        if (freeAdl.options.meal) {
          freeAdl.mealPrice = []
          freeAdl.daysArray.forEach((freeAdlDay) => {
            let mealDay = {}
            state.tour.meal.forEach((meal) => {
              if (meal.obj.daysArray.find(day => day == freeAdlDay)) {
                mealDay = meal
              }
              if (!_.isEqual(mealDay, {})) {
                freeAdl.mealPrice.push({
                  day: freeAdlDay,
                  mealName: `${mealDay.meal.name}: ${mealDay.obj.name}`,
                  mealPrice: mealDay.obj.price,
                })
              }
            })
            // If no meal in all tour.mealArray add error
            if (_.isEqual(mealDay, {})) {
              state.freeAdlErrors.noMeal.push({
                name: '"Бесплатный взрослый": ' + freeAdl.name,
                day: freeAdlDay,
              }) 
              console.log('БВ. Нет питания.', state)
              state.staffErrors.show = true
            } 
            // Remove duplicates
            freeAdl.mealPrice = _.uniqWith(freeAdl.mealPrice, _.isEqual)
          })
        }
        state.tour.options.freeAdls.forEach((freeAdl) => {
          let total = 0
          if (freeAdl.hotelPrice) {
            freeAdl.hotelPrice.forEach(room => total += parseFloat(room.hotelStdPrice))
          }
          if (freeAdl.mealPrice) {
            freeAdl.mealPrice.forEach(meal => total += parseFloat(meal.mealPrice))
          }
          if (freeAdl.museums.length > 0) {
            freeAdl.museums.forEach(event => total += parseFloat(event.price))
          }
          freeAdl.totalPrice = total
          freeAdl.totalPricePerSeat = parseFloat((total / state.tour.qnt).toFixed(2))
          freeAdl.correctedPrice = total
          freeAdl.commissionPrice = total
        })
      })
    },
    setMuseumInEditMode: (state, updData) => {
      state.tour.museum = updData
    },
    setEditorsContent: (state, content) => {
      state.tour.editorsContent = content
    },
    setTourName: (state, name) => {
      state.tour.options.name = name
    },
    calculateTourTotalPrice: (state) => {
      let summ = 0
      state.tour.transport.forEach((transport) => {
        summ += parseInt(transport.pricePerSeat)
      })
      state.tour.museum.forEach((museum) => {
        // Search price by current customer Id
        let price = JSON.parse(museum.obj.extra).priceList.find((item) => {
          return item.customerId == state.tour.calc.currentCustomer
        })
        // If event have no price with current customer Id set default customer
        if (price == undefined) price = JSON.parse(museum.obj.extra).priceList[state.tour.calc.defaultCustomer]
        summ += parseInt(price.price)
      })
      state.tour.museumCustomOrder.forEach((order) => {
        summ += parseInt(order.pricePerSeat)
      })
      state.tour.hotel.forEach((hotel) => {
        summ += parseInt(hotel.obj.totalPrice)
        // CHD prices
        let isChd = false
        let currentPrice = state.tour.calc.priceList.find((item) => {
          return item.id == state.tour.calc.currentCustomer
        })
        isChd = currentPrice.isChd
        if (isChd) {
          summ -= parseInt(hotel.obj.totalPrice)
          const data = JSON.parse(hotel.obj.extra)
          const stdPrice = parseInt(data.priceList.chd.std)
          summ += (stdPrice * hotel.obj.day)
        }
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.obj.totalPrice)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.pricePerSeat)
        console.log(guide)
        if (guide.guide.options.totalPricePerSeat > 0) {
          summ += parseInt(guide.guide.options.totalPricePerSeat)
        }
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.pricePerSeat)
        if (attendant.attendant.options.totalPricePerSeat > 0) {
          summ += parseInt(attendant.attendant.options.totalPricePerSeat)
        }
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.pricePerSeat)
      })
      state.tour.options.drivers.forEach((driver) => {
        summ += driver.totalPricePerSeat
      })
      state.tour.options.freeAdls.forEach((freeAdl) => {
        summ += freeAdl.totalPricePerSeat
      })
      state.tour.totalPrice = summ
      state.tour.calc.priceList[state.tour.calc.currentCustomer].nettoPrice = summ
    },
    calculateTourCorrectedPrice: (state) => {
      let summ = 0
      let netto = 0
      let standardHotel = 0
      let nettoStandardHotel = 0
      let singleHotel = 0
      let nettoSingleHotel = 0
      let extraHotel = 0
      let nettoExtraHotel = 0
      
      state.tour.transport.forEach((transport) => {
        summ += transport.correctedPricePerSeat
        netto += transport.pricePerSeat
      })
      state.tour.museum.forEach((museum) => {
        summ += parseInt(museum.correctedPrice)
        netto += parseInt(museum.correctedPrice * 100 / (100 + parseInt(museum.correction)))       
      })
      state.tour.museumCustomOrder.forEach((order) => {
        summ += parseInt(order.correctedPricePerSeat)
        netto += parseInt(order.pricePerSeat)
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.correctedPrice)
        netto += parseInt(meal.obj.totalPrice)
      })
      state.tour.guide.forEach((guide) => {
        // Guide price for customers
        summ += parseInt(guide.correctedPricePerSeat)
        netto += parseInt(guide.pricePerSeat)
        // Staff
        // Guide options: hotel, meal, events.
        summ += guide.guide.options.correctedPricePerSeat
        netto += guide.guide.options.totalPricePerSeat
      })
      state.tour.attendant.forEach((attendant) => {
        // Attendant price for customers
        summ += parseInt(attendant.correctedPricePerSeat)
        netto += parseInt(attendant.pricePerSeat)
        // Staff
        // Attendant options: hotel, meal, events.
        summ += attendant.attendant.options.correctedPricePerSeat
        netto += attendant.attendant.options.totalPricePerSeat
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.correctedPricePerSeat)
        netto += parseInt(price.pricePerSeat)
      })
      state.tour.hotel.forEach((hotel) => {
        // ADL prices
        const data = JSON.parse(hotel.obj.extra)
        const stdPrice = parseInt(data.priceList.adl.std)
        standardHotel += parseInt(
          (stdPrice * hotel.obj.day)
          +
          (stdPrice * hotel.obj.day * hotel.correction) / 100
        )
        nettoStandardHotel += parseInt(
          (stdPrice * hotel.obj.day)
        )
        const singlePrice = parseInt(data.priceList.adl.sngl)
        singleHotel += parseInt(
          (singlePrice * hotel.obj.day)
          +
          (singlePrice * hotel.obj.day * hotel.correction) / 100
        )
        nettoSingleHotel += parseInt(
          (singlePrice * hotel.obj.day)
        )
        const extraPrice = parseInt(data.priceList.adl.extra)
        extraHotel += parseInt(
          (extraPrice * hotel.obj.day)
          + 
          (extraPrice * hotel.obj.day * hotel.correction) / 100
        )
        nettoExtraHotel += parseInt(
          (extraPrice * hotel.obj.day)
        )
        // CHD prices
        let isChd = false
        let currentPrice = state.tour.calc.priceList.find((item) => {
          return item.id == state.tour.calc.currentCustomer
        })
        isChd = currentPrice.isChd
        if (isChd) {
          standardHotel = 0
          nettoStandardHotel = 0
          extraHotel = 0
          nettoExtraHotel = 0
          const stdPrice = parseInt(data.priceList.chd.std)
          standardHotel += parseInt(
            (stdPrice * hotel.obj.day)
            +
            (stdPrice * hotel.obj.day * hotel.correction) / 100
          )
          nettoStandardHotel += parseInt(
            (stdPrice * hotel.obj.day)
          )
          const extraPrice = parseInt(data.priceList.chd.extra)
          extraHotel += parseInt(
            (extraPrice * hotel.obj.day)
            + 
            (extraPrice * hotel.obj.day * hotel.correction) / 100
          )
          nettoExtraHotel += parseInt(
            (extraPrice * hotel.obj.day)
          )
        }
        console.log('calculate tour corrected: ', state.tour)
      })
      state.tour.options.drivers.forEach((driver) => {
        summ += driver.correctedPricePerSeat
        netto += driver.totalPricePerSeat
      })
      state.tour.options.freeAdls.forEach((freeAdl) => {
        summ += freeAdl.correctedPricePerSeat
        netto += freeAdl.totalPricePerSeat
      })
      let calcCustomer = state.tour.calc.priceList.find((item) => {
        return item.id == state.tour.calc.currentCustomer
      })
      calcCustomer.standardPrice = summ + standardHotel
      calcCustomer.nettoStandardPrice = netto + nettoStandardHotel
      calcCustomer.singlePrice = summ + singleHotel
      calcCustomer.nettoSinglePrice = netto + nettoSingleHotel
      calcCustomer.addPrice = summ + extraHotel
      calcCustomer.nettoAddPrice = netto + nettoExtraHotel
      state.tour.correctedPrice = summ + standardHotel
    },
    calculateTourCommissionPrice(state) {
      let summ = 0
      let correctedStandardHotel = 0
      let commissionStandardHotel = 0
      let correctedSingleHotel = 0
      let commissionSingleHotel = 0
      let correctedExtraHotel = 0
      let commissionExtraHotel = 0
      state.tour.transport.forEach((transport) => {
        summ += transport.commissionPricePerSeat
      })
      state.tour.museum.forEach((museum) => {
        summ += museum.commissionPrice
      })
      state.tour.museumCustomOrder.forEach((order) => {
        summ += order.commissionPricePerSeat
      })
      state.tour.meal.forEach((meal) => {
        summ += meal.commissionPrice
      })
      state.tour.guide.forEach((guide) => {
        // Guide price for customers
        summ += guide.commissionPricePerSeat
        // Staff
        // Guide options: hotel, meal, events.
        summ += guide.guide.options.commissionPricePerSeat
      })
      state.tour.attendant.forEach((attendant) => {
        // Attendant price for customers
        summ += attendant.commissionPricePerSeat
        // Staff
        // Attendant options: hotel, meal, events.
        summ += attendant.attendant.options.commissionPricePerSeat
      })
      state.tour.customPrice.forEach((customPrice) => {
        summ += customPrice.commissionPricePerSeat
      })
      state.tour.hotel.forEach((hotel) => {
        // ADL prices
        const data = JSON.parse(hotel.obj.extra)
        const stdPrice = parseInt(data.priceList.adl.std)
        correctedStandardHotel += parseInt(
          (stdPrice * hotel.obj.day)
          +
          (stdPrice * hotel.obj.day * hotel.correction) / 100
        )
        commissionStandardHotel += correctedStandardHotel 
          + (correctedStandardHotel * hotel.commission / 100)
        const singlePrice = parseInt(data.priceList.adl.sngl)
        correctedSingleHotel += parseInt(
          (singlePrice * hotel.obj.day)
          +
          (singlePrice * hotel.obj.day * hotel.correction) / 100
        )
        commissionSingleHotel += correctedSingleHotel
          + (correctedSingleHotel * hotel.commission / 100)
        const extraPrice = parseInt(data.priceList.adl.extra)
        correctedExtraHotel += parseInt(
          (extraPrice * hotel.obj.day)
          + 
          (extraPrice * hotel.obj.day * hotel.correction) / 100
        )
        commissionExtraHotel += correctedExtraHotel
          + (correctedExtraHotel * hotel.commission / 100)
        // CHD prices
        let isChd = false
        let currentPrice = state.tour.calc.priceList.find((item) => {
          return item.id == state.tour.calc.currentCustomer
        })
        isChd = currentPrice.isChd
        if (isChd) {
          correctedStandardHotel = 0
          commissionStandardHotel = 0
          correctedExtraHotel = 0
          commissionExtraHotel = 0
          const stdPrice = parseInt(data.priceList.chd.std)
          correctedStandardHotel += parseInt(
            (stdPrice * hotel.obj.day)
            +
            (stdPrice * hotel.obj.day * hotel.correction) / 100
          )
          commissionStandardHotel = correctedStandardHotel
            + (correctedStandardHotel * hotel.commission / 100)
          const extraPrice = parseInt(data.priceList.chd.extra)
          correctedExtraHotel += parseInt(
            (extraPrice * hotel.obj.day)
            + 
            (extraPrice * hotel.obj.day * hotel.correction) / 100
          )
          commissionExtraHotel = correctedExtraHotel
            + (correctedExtraHotel * hotel.commission / 100)
        }
      })
      let calcCustomer = state.tour.calc.priceList.find((item) => {
        return item.id == state.tour.calc.currentCustomer
      })
      state.tour.options.drivers.forEach((driver) => {
        summ += driver.commissionPricePerSeat
      })
      state.tour.options.freeAdls.forEach((freeAdl) => {
        summ += freeAdl.commissionPricePerSeat
      })
      calcCustomer.commissionStandardPrice = summ + commissionStandardHotel
      calcCustomer.commissionSinglePrice = summ + commissionSingleHotel
      calcCustomer.commissionExtraPrice = summ + commissionExtraHotel
      state.tour.commissionPrice = summ + commissionStandardHotel
    },
    setCorrectionToAll: (state, correction) => {
      if (correction == NaN || correction == '') {
        correction = 0
      }
      state.tour.transport.forEach((transport) => {
        transport.correction = parseInt(correction)
      })
      state.tour.museum.forEach((museum) => {
        museum.correction = correction
      })
      state.tour.museumCustomOrder.forEach((order) => {
        order.correction = correction
      })
      state.tour.hotel.forEach((hotel) => {
        hotel.correction = correction
      })
      state.tour.meal.forEach((meal) => {
        meal.correction = correction
      })
      state.tour.guide.forEach((guide) => {
        guide.correction = correction
        guide.guide.options.correction = correction
      })
      state.tour.attendant.forEach((attendant) => {
        attendant.correction = correction
        attendant.attendant.options.correction = correction
      })
      state.tour.customPrice.forEach((price) => {
        price.correction = correction
      })
      state.tour.options.drivers.forEach((driver) =>
        driver.correction = correction
      )
      state.tour.options.freeAdls.forEach((freeAdl) => {
        freeAdl.correction = correction
      })
      console.log('correction to all: ', state.tour)
    },
    setCorrectedPriceValues(state) {
      // Add price-fields to Transport
      state.tour.transport.forEach((transport) => {
        transport.correctedPricePerSeat = 0
        if (transport.correction > 0) {
          transport.correctedPricePerSeat = 
          parseInt(
            (transport.pricePerSeat + 
              transport.pricePerSeat * parseInt(transport.correction) / 100)
          )
        }
        else {
          transport.correctedPricePerSeat = parseInt(transport.pricePerSeat)
        }
      })
      // Add price-fields to Museum
      state.tour.museum.forEach((museum) => {
        // Search price by current customer Id
        let price = JSON.parse(museum.obj.extra).priceList.find((item) => {
          return item.customerId == state.tour.calc.currentCustomer
        })
        // If event have no price with current customer Id set default customer
        if (price == undefined) price = JSON.parse(museum.obj.extra).priceList[state.tour.calc.defaultCustomer]
        // Calculate corrected price
        museum.correctedPrice = 0
        if (museum.correction > 0) {
          museum.correctedPrice = 
            price.price 
            + (price.price * museum.correction / 100) 
        } else {
          museum.correctedPrice = price.price
        }
      })
      // Calculate corrected price to museum custom order
      state.tour.museumCustomOrder.forEach((order) => {
        if (order.correction > 0) {
          order.correctedPricePerSeat = 
            parseInt(order.pricePerSeat) + 
            (order.pricePerSeat * order.correction / 100)
        } else {
          order.correctedPricePerSeat = parseInt(order.pricePerSeat)
        }
      })
      // Add price-fields to Hotel
      state.tour.hotel.forEach((hotel) => {
        if (hotel.correction > 0) {
          hotel.correctedPrice = 
            parseInt(hotel.obj.totalPrice) + 
            (hotel.obj.totalPrice * hotel.correction / 100) 
        } else {
          hotel.correctedPrice = parseInt(hotel.obj.totalPrice)
        }
      })
      // Add price-fields to Meal
      state.tour.meal.forEach((meal) => {
        if (meal.correction > 0) {
          meal.correctedPrice = 
            parseInt(meal.obj.totalPrice) + 
            (meal.obj.totalPrice * meal.correction / 100) 
        } else {
          meal.correctedPrice = parseInt(meal.obj.totalPrice)
        }
      })
      // Add price-fields to Guide
      state.tour.guide.forEach((guide) => {
        if (guide.correction > 0) {
          // Guide price for customers
          guide.correctedPricePerSeat = 
            guide.pricePerSeat + 
            (guide.pricePerSeat * guide.correction / 100) 
          } else {
          // Guide price for customers
          guide.correctedPricePerSeat = guide.pricePerSeat
        }
        if (guide.guide.options.correction > 0) {
          // Staff
          // Guide options: hotel, meal, events.
          // Price per seat.
          guide.guide.options.correctedPricePerSeat = 
            guide.guide.options.totalPricePerSeat + 
            (guide.guide.options.totalPricePerSeat 
              * guide.guide.options.correction / 100)
          guide.guide.options.correctedPricePerSeat = parseFloat(guide.guide.options.correctedPricePerSeat.toFixed(2))
        } else {
          // Staff
          // Guide options: hotel, meal, events.
          // Price per seat.
          guide.guide.options.correctedPricePerSeat = 
            parseFloat(guide.guide.options.totalPricePerSeat.toFixed(2))
        }
      })
      // Add price-fields to Attendant
      state.tour.attendant.forEach((attendant) => {
        if (attendant.correction > 0) {
          attendant.correctedPricePerSeat = 
            attendant.pricePerSeat + 
            (attendant.pricePerSeat * attendant.correction / 100) 
        } else {
          attendant.correctedPricePerSeat = attendant.pricePerSeat
        }
        if (attendant.attendant.options.correction > 0) {
          // Staff
          // Attendant options: hotel, meal, events.
          // Price per seat.
          attendant.attendant.options.correctedPricePerSeat = 
          attendant.attendant.options.totalPricePerSeat + 
            (attendant.attendant.options.totalPricePerSeat 
              * attendant.attendant.options.correction / 100)
              attendant.attendant.options.correctedPricePerSeat = parseFloat(attendant.attendant.options.correctedPricePerSeat.toFixed(2))
        } else {
          // Staff
          // Guide options: hotel, meal, events.
          // Price per seat.
          attendant.attendant.options.correctedPricePerSeat = 
            parseFloat(attendant.attendant.options.totalPricePerSeat.toFixed(2))
        }
      })
      // Add price-fields to Custom Price (Services)
      state.tour.customPrice.forEach((price) => {
        if (price.correction > 0) {
          price.correctedPricePerSeat = 
          parseInt(price.pricePerSeat) + 
            (parseInt(price.pricePerSeat) * parseInt(price.correction) / 100) 
        } else {
          price.correctedPricePerSeat = parseInt(price.pricePerSeat)
        }
      })
      // Calculate corrected price to Drivers
      state.tour.options.drivers.forEach((driver) => {
        if (driver.correction > 0) {
          driver.correctedPricePerSeat = 
          parseFloat(driver.totalPricePerSeat) +
            (parseFloat(driver.totalPricePerSeat) * parseFloat(driver.correction) / 100)
        } else {
          driver.correctedPricePerSeat = driver.totalPricePerSeat
        }
        driver.correctedPricePerSeat = parseFloat(driver.correctedPricePerSeat.toFixed(2))
      })
      // Calculate corrected price to FreeAdls
      state.tour.options.freeAdls.forEach((freeAdl) => {
        if (freeAdl.correction > 0) {
          freeAdl.correctedPricePerSeat = 
          parseFloat(freeAdl.totalPricePerSeat) +
            (parseFloat(freeAdl.totalPricePerSeat) * parseFloat(freeAdl.correction) / 100)
        } else {
          freeAdl.correctedPricePerSeat = freeAdl.totalPricePerSeat
        }
        freeAdl.correctedPricePerSeat = parseFloat(freeAdl.correctedPricePerSeat.toFixed(2))
      })
      console.log('corrected price values: ', state.tour)
    },
    setCommissionToAll: (state, commission) => {
      if (commission == NaN || commission == '') {
        commission = 0
      }
      state.tour.transport.forEach((transport) => {
        transport.commission = parseInt(commission)
      })
      state.tour.museum.forEach((museum) => {
        museum.commission = commission
      })
      state.tour.museumCustomOrder.forEach((order) => {
        order.commission = commission
      })
      state.tour.hotel.forEach((hotel) => {
        hotel.commission = commission
      })
      state.tour.meal.forEach((meal) => {
        meal.commission = commission
      })
      state.tour.guide.forEach((guide) => {
        guide.commission = commission
        guide.guide.options.commission = commission
      })
      state.tour.attendant.forEach((attendant) => {
        attendant.commission = commission
        attendant.attendant.options.commission = commission
      })
      state.tour.customPrice.forEach((price) => {
        price.commission = commission
      })
      state.tour.options.drivers.forEach((driver) => {
        driver.commission = commission
      })
      state.tour.options.freeAdls.forEach((freeAdl) => {
        freeAdl.commission = commission
      })
    },
    setCommissionPriceValues(state) {
      // Add price-fields to Transport
      state.tour.transport.forEach((transport) => {
        transport.commissionPricePerSeat = 0
        if (transport.commission > 0) {
          transport.commissionPricePerSeat = 
          parseInt(
            (transport.correctedPricePerSeat + 
              transport.correctedPricePerSeat * parseInt(transport.commission) / 100)
          )
        }
        else {
          transport.commissionPricePerSeat = parseInt(transport.correctedPricePerSeat)
        }
      })
      // Add price-fields to Museum
      state.tour.museum.forEach((museum) => {
        // Search price by current customer Id
        let price = JSON.parse(museum.obj.extra).priceList.find((item) => {
          return item.customerId == state.tour.calc.currentCustomer
        })
        // If event have no price with current customer Id set default customer
        if (price == undefined) price = JSON.parse(museum.obj.extra).priceList[state.tour.calc.defaultCustomer]
        // Calculate corrected price
        museum.commissionPrice = 0
        if (museum.commission > 0) {
          museum.commissionPrice = 
            museum.correctedPrice 
            + (museum.correctedPrice * museum.commission / 100) 
        } else {
          museum.commissionPrice = museum.correctedPrice
        }
      })
      // Calculate museum custum order commission prices
      state.tour.museumCustomOrder.forEach((order) => {
        if (order.commission > 0) {
          order.commissionPricePerSeat = 
            order.correctedPricePerSeat +
            (order.correctedPricePerSeat * order.commission / 100)
        } else {
          order.commissionPricePerSeat = order.correctedPricePerSeat
        }
      })
      // Add price-fields to Hotel
      state.tour.hotel.forEach((hotel) => {
        if (hotel.commission > 0) {
          hotel.commissionPrice = 
            hotel.correctedPrice + 
            (hotel.correctedPrice * hotel.commission / 100) 
        } else {
          hotel.commissionPrice = hotel.correctedPrice
        }
      })
      // Add price-fields to Meal
      state.tour.meal.forEach((meal) => {
        if (meal.commission > 0) {
          meal.commissionPrice = 
            meal.correctedPrice + 
            (meal.correctedPrice * meal.commission / 100) 
        } else {
          meal.commissionPrice = meal.correctedPrice
        }
      })
      // Add price-fields to Guide
      state.tour.guide.forEach((guide) => {
        if (guide.commission > 0) {
          // Guide price for customers
          guide.commissionPricePerSeat = 
            guide.correctedPricePerSeat + 
            (guide.correctedPricePerSeat * guide.commission / 100) 
        } else {
          // Guide price for customers
          guide.commissionPricePerSeat = guide.correctedPricePerSeat
        }
        if (guide.guide.options.commission > 0) {
          // Staff
          // Guide options: hotel, meal, events.
          guide.guide.options.commissionPricePerSeat = 
            guide.guide.options.correctedPricePerSeat + 
            (guide.guide.options.correctedPricePerSeat 
              * guide.guide.options.commission / 100)
              guide.guide.options.commissionPricePerSeat = parseFloat(guide.guide.options.commissionPricePerSeat.toFixed(2))
        } else {
          // Staff
          // Guide options: hotel, meal, events.
          guide.guide.options.commissionPricePerSeat = 
            parseFloat(guide.guide.options.correctedPricePerSeat.toFixed(2))
        }
      })
      // Add price-fields to Attendant
      state.tour.attendant.forEach((attendant) => {
        if (attendant.commission > 0) {
          attendant.commissionPricePerSeat = 
            attendant.correctedPricePerSeat + 
            (attendant.correctedPricePerSeat * attendant.commission / 100) 
        } else {
          attendant.commissionPricePerSeat = attendant.correctedPricePerSeat
        }
        if (attendant.attendant.options.commission > 0) {
          // Staff
          // Attendant options: hotel, meal, events.
          attendant.attendant.options.commissionPricePerSeat = 
            attendant.attendant.options.correctedPricePerSeat + 
            (attendant.attendant.options.correctedPricePerSeat 
              * attendant.attendant.options.commission / 100)
              attendant.attendant.options.commissionPricePerSeat = parseFloat(attendant.attendant.options.commissionPricePerSeat.toFixed(2))
        } else {
          // Staff
          // Attendant options: hotel, meal, events.
          attendant.attendant.options.commissionPricePerSeat = 
            parseFloat(attendant.attendant.options.correctedPricePerSeat.toFixed(2))
        }
      })
      // Add price-fields to Custom Price (Services)
      state.tour.customPrice.forEach((price) => {
        if (price.commission > 0) {
          price.commissionPricePerSeat = 
          price.correctedPricePerSeat + 
            (price.correctedPricePerSeat * price.commission / 100) 
        } else {
          price.commissionPricePerSeat = price.correctedPricePerSeat
        }
      })
      // Calculate commission price to drivers
      state.tour.options.drivers.forEach((driver) => {
        if (driver.commission > 0) {
          driver.commissionPricePerSeat = 
          parseFloat(driver.correctedPricePerSeat) +
            (parseFloat(driver.correctedPricePerSeat) * parseFloat(driver.commission) / 100)
        } else {
          driver.commissionPricePerSeat = parseFloat(driver.correctedPricePerSeat.toFixed(2))
        }
        driver.commissionPricePerSeat = parseFloat(driver.commissionPricePerSeat.toFixed(2))
      })
      // Calculate commission price to FreeAdls
      state.tour.options.freeAdls.forEach((freeAdl) => {
        if (freeAdl.commission > 0) {
          freeAdl.commissionPricePerSeat = 
          parseFloat(freeAdl.correctedPricePerSeat) +
            (parseFloat(freeAdl.correctedPricePerSeat) * parseFloat(freeAdl.commission) / 100)
        } else {
          freeAdl.commissionPricePerSeat = parseFloat(freeAdl.correctedPricePerSeat.toFixed(2))
        }
        freeAdl.commissionPricePerSeat = parseFloat(freeAdl.commissionPricePerSeat.toFixed(2))
      })
    },
    setEditTour(state, tour) {
      state.tour = JSON.parse(tour.extra)
      state.editMode = true
      state.tour.id = tour.id
    },
    setCurrentCustomerType(state, value) {
      state.tour.calc.currentCustomer = value
    },
    setTourCalcCustomerTypes(state, customerTypes) {
      state.tour.calc.priceList = []
      let idesArray = []
      customerTypes.forEach((customer) => {
        if (customer.name.includes("Взрослый")) {
          state.tour.calc.defaultCustomer = customer.id
          state.tour.calc.currentCustomer = customer.id
        }
        if (!idesArray.includes(customer.id)){
          state.tour.calc.priceList.push({
            ...customer,
            standardPrice: 0,
            singlePrice: 0,
            addPrice: 0,
            isChd: false,
            isInf: false,
          })
          idesArray.push(customer.id)
        }
      })
      console.log(state, 'ides array: ', idesArray)
    },
    setFreeAdlsOptions(state, updData) {
      if (updData.delete) {
        state.tour.options.freeAdls = state.tour.options.freeAdls.filter((item) => {
          return item.id != updData.delete
        })
      } else {
        state.tour.options.freeAdls.push(updData)
      }
    },
    reset(state) {
      state.tour = {
        id: NaN,
        options: {
          name: '',
          tourType: 0,
          cities: [],
          tourGrade: [],
          tourLanguages: [1],
          days: NaN,
          nights: NaN,
          dateStart: new Date().toISOString().substr(0, 10),
          qnt: 0,
          drivers: {
            hotel: [],
            meal: [],
          },
          freeAdls: [],
        },
        transport: [],
        museum: [],
        museumCustomOrder: [],
        hotel: [],
        meal: [],
        alternativeMeal: [],
        guide: [],
        attendant: [],
        customPrice: [],
        editorsContent: [],
        totalPrice: NaN,
        ordered: 0,
        qnt: 0,
        calc: {
          currentCustomer: 0,
          priceList: [],
        },
        commissionPrice: 0,
      }
    },
    setManualCommissionPriceValues(state, commissionValue) {
      let com = parseFloat(commissionValue).toFixed(2)
      state.tour.calc.priceList.forEach((price) => {
        price.commissionExtraPrice = parseFloat(price.addPrice) + parseFloat(com)
        price.commissionStandardPrice = parseFloat(price.standardPrice) + parseFloat(com)
        price.commissionSinglePrice = parseFloat(price.singlePrice) + parseFloat(com)
      })
      state.tour.calc.commissionManualValue = com
    },
    setManualCommissionMode(state, flag) {
      if (flag) {
        state.tour.calc.commissionManualMode = true
      } else {
        state.tour.calc.commissionManualMode = false
      }
    },
    setCanSave(state, flag) {
      state.canSave = flag
    }
  },
  state: {
    editMode: false,
    canSave: false,
    tourOptions: [],
    tour: {
      id: NaN,
      options: {
        name: '',
        tourType: 0,
        cities: [],
        tourGrade: [],
        tourLanguages: [1],
        days: NaN,
        nights: NaN,
        dateStart: new Date().toISOString().substr(0, 10),
        qnt: 0,
        drivers: {
          hotel: [],
          meal: [],
        },
        freeAdls: [],
      },
      transport: [],
      museum: [],
      museumCustomOrder: [],
      hotel: [],
      meal: [],
      alternativeMeal: [],
      guide: [],
      attendant: [],
      customPrice: [],
      editorsContent: [],
      totalPrice: NaN,
      ordered: 0,
      qnt: 0,
      calc: {
        currentCustomer: 0,
        priceList: [],
      },
      correctedPrice: 0,
      commissionPrice: 0,
    },
    constructorCurrentStage: 'Initial stage',
    // constructorCurrentStage: 'Guide is set',
    actualCities: [],
    actualMuseum: [],
    actualHotel: [],
    actualMeal: [],
    actualGuide: [],
    actualAttendant: [],
    actualTransport: [],
    staffErrors: {
      noHotel: [],
      noMeal: [],
      show: true,
    },
    freeAdlErrors: {
      noHotel: [],
      noMeal: [],
      show: true,
    },
  },
  getters: {
    allState(state) {
      return state
    },
    allTourOptions(state) {
      return state.tourOptions
    },
    getConstructorCurrentStage(state) {
      return state.constructorCurrentStage
    },
    // getActualCities(state) {
    //   return state.tour.options.cities
    // },
    getActualTransport(state) {
      return state.actualTransport
    },
    getActualMuseum(state) {
      return state.actualMuseum
    },
    getTour(state) {
      return state.tour
    },
    getActualHotel(state) {
      return state.actualHotel
    },
    getActualMeal(state) {
      return state.actualMeal
    },
    getActualGuide(state) {
      return state.actualGuide
    },
    getActualAttendant(state) {
      return state.actualAttendant
    },
    getCustomPrice(state) {
      return state.tour.customPrice
    },
    getCorrectedPrice(state) {
      let summ = 0
      state.tour.transport.forEach((transport) => {
        summ += parseInt(transport.correctedPricePerSeat)
      })
      state.tour.museum.forEach((museum) => {
        summ += parseInt(museum.correctedPrice)
      })
      state.tour.hotel.forEach((hotel) => {
        summ += parseInt(hotel.correctedPrice)
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.correctedPrice)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.correctedPrice)
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.correctedPrice)
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.correctedPricePerSeat)
      })
      return summ
    },
    getTourName(state) {
      return state.tour.options.name
    },
    getCurrentTourCustomers(state) {
      let result = []
      state.tour.museum.forEach((museum) => {
        if (!JSON.parse(museum.obj.extra).isCustomOrder) {
          JSON.parse(museum.obj.extra).priceList.forEach((price) => {
            result.push({
              id: price.customerId,
              name: price.customerName,
              age: price.customerAge,
            })
          })
        }
      })
      console.log('before: ', result)
      console.log('after: ', _.uniqWith(result, _.isEqual))
      return _.uniqWith(result, _.isEqual)
    },
    getTourCalc(state) {
      return state.tour.calc
    },
    getEditMode(state) {
      return state.editMode
    },
    getAverageCommission(state) {
      let summ = 0
      let count = 0
      state.tour.transport.forEach((transport) => {
        if (transport.commission == '' || !transport.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(transport.commission)
          count += 1
        }
      })
      state.tour.museum.forEach((museum) => {
        if (museum.commission == '' || !museum.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(museum.commission)
          count += 1
        }
      })
      state.tour.hotel.forEach((hotel) => {
        if (hotel.commission == '' || !hotel.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(hotel.commission)
          count += 1
        }
      })
      state.tour.meal.forEach((meal) => {
        if (meal.commission == '' || !meal.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(meal.commission)
          count += 1
        }
      })
      state.tour.guide.forEach((guide) => {
        if (guide.commission == '' || !guide.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(guide.commission)
          count += 1
        }
      })
      state.tour.attendant.forEach((attendant) => {
        if (attendant.commission == '' || !attendant.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(attendant.commission)
          count += 1
        }
      })
      state.tour.customPrice.forEach((customPrice) => {
        if (customPrice.commission == '' || !customPrice.commission) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(customPrice.commission)
          count += 1
        }
      })
      return parseFloat(summ / count).toFixed(2)
    },
    getAverageCorrection(state) {
      let summ = 0
      let count = 0
      state.tour.transport.forEach((transport) => {
        if (transport.correction == '' || !transport.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(transport.correction)
          count += 1
        }
      })
      state.tour.museum.forEach((museum) => {
        if (museum.correction == '' || !museum.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(museum.correction)
          count += 1
        }
      })
      state.tour.hotel.forEach((hotel) => {
        if (hotel.correction == '' || !hotel.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(hotel.correction)
          count += 1
        }
      })
      state.tour.meal.forEach((meal) => {
        if (meal.correction == '' || !meal.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(meal.correction)
          count += 1
        }
      })
      state.tour.guide.forEach((guide) => {
        if (guide.correction == '' || !guide.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(guide.correction)
          count += 1
        }
      })
      state.tour.attendant.forEach((attendant) => {
        if (attendant.correction == '' || !attendant.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(attendant.correction)
          count += 1
        }
      })
      state.tour.customPrice.forEach((customPrice) => {
        if (customPrice.correction == '' || !customPrice.correction) {
          summ += 0
          count += 1
        } else {
          summ += parseInt(customPrice.correction)
          count += 1
        }
      })
      return parseFloat(summ / count).toFixed(2)
    },
    getStaffErrors(state) {
      return state.staffErrors
    },
    getFreeAdlErrors(state) {
      return state.freeAdlErrors
    },
    getCanSave(state) {
      return state.canSave
    }
  }
}