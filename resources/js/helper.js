export const dayName = (day) => {
    const days = ['Понеділок', 'Вівторок', 'Середа', 'Четвер', 'П`ятниця', 'Субота', 'Неділя']
    return days[day]
}

export const formatPhoneNumber = (value) => {
    value = value.replace(/\D/g, '');
    if (value.length > 3) {
        value = `${value.slice(0, 3)}-${value.slice(3)}`;
    }
    if (value.length > 7) {
        value = `${value.slice(0, 7)}-${value.slice(7)}`;
    }
    if (value.length > 10) {
        value = `${value.slice(0, 10)}-${value.slice(10)}`;
    }
    if (value.length > 13) {
        value = `${value.slice(0, 13)}`;
    }

    return value;
}