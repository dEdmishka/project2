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

export const formatDate = (newDate) => {
    const date = new Date(newDate);
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`
}

export const formatTime = (newDate) => {
    const date = new Date(newDate);
    return `${formatDate(date)} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`
}

export const hasElements = (obj) => Object.keys(obj).length > 0;