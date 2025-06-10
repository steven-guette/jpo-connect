import BaseButton from './BaseButton'

const GhostButton = ({ variant = 'subtle', ...props }) => (
    <BaseButton color='grayblue' variant={variant} {...props} />
);

export default GhostButton;