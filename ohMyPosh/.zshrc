# Path to your oh-my-zsh installation.
export ZSH="/root/.oh-my-zsh"

# Set name of the theme to load.
ZSH_THEME="powerlevel10k/powerlevel10k"

# Source Powerlevel10k theme configuration
[[ ! -f ~/.p10k.zsh ]] || source ~/.p10k.zsh

# Initialize Oh My Posh
eval "$(oh-my-posh init zsh --config /etc/oh-my-posh/themes/paradox.omp.json)"

# Add your other configurations here
