import BaseButton from './BaseButton'

const SecondaryButton = ({ variant = 'filled', ...props }) => (
    <BaseButton color='accent' variant={variant} {...props} />
);

export default SecondaryButton;