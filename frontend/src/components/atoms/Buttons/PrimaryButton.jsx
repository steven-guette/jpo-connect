import BaseButton from './BaseButton'

const PrimaryButton = ({ variant = 'filled', ...props }) => (
    <BaseButton color='laplateforme' variant={variant} {...props} />
);

export default PrimaryButton;