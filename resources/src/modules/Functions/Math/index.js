export function math_formatter(value, decimals) {
    return (Math.floor(value * Math.pow(10, decimals)) / Math.pow(10, decimals)).toFixed(decimals);
};

export function math_percentage(value, percentage) {
    return (parseFloat(value) / 100) * parseFloat(percentage);
};

export function math_percentage_of_number(num, num2) {
    return ((100 * num) / num2).toFixed(2);
};
