pipeline {
  agent {label 'jenkins-slave'}
  stages {
    stage('Verification') {
      steps {
        checkout scm
        validateDeclarativePipeline 'Jenkinsfile'
        sh 'php -v'
        sh 'php -i'
      }
    }


    stage('Composer & yarn Install') {
        steps {
            sh 'composer install'
            sh 'yarn install'
        }
    }

    stage('Testing environment setup') {
        steps {
            withCredentials(bindings: [file(credentialsId: 'env-gestion-stoque-test', variable: 'envfile')]) {
              writeFile(file: '.env', text: readFile(envfile))
            }
            sh 'php artisan key:generate'
            sh 'php artisan migrate:fresh --seed'
        }
    }

    stage('PHP Testing') {
        steps {
            sh 'php artisan test'
        }
    }

    stage('SonarScanner')
        environment {
                scannerHome = tool 'scanner'
        }
        steps {
            withSonarQubeEnv(installationName: 'SonarServ', credentialsId: 'sonar-token') {
                sh '${scannerHome}/bin/sonar-scanner'
            }
        }
    }

    stage('Fresh Database')
        steps {
            sh "php artisan migrate:reset"
            sh "rm .env"
        }
    }


    stage('Production environment setup') {
      steps {

        withCredentials(bindings: [file(credentialsId: 'env-gestion-stoque-prod', variable: 'envfile')]) {
          writeFile(file: '.env', text: readFile(envfile))
        }

        sh 'php artisan key:generate'
      }
    }

    stage('Build & tag container') {
      steps {
        container('docker') {
            script {
                docker.withRegistry('https://docker.io', 'docker-hub-credentials') {
                    def img = docker.build "simonloudev/celobat"
                    img.push("${env.BUILD_NUMBER}")
                    img.push("latest")
                }
            }
        }
      }
    }

  }
}
