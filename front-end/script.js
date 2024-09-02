gsap.registerPlugin(MotionPathPlugin);
const circlePath = MotionPathPlugin.convertToPath("#holder", false)[0];
circlePath.id = "circlePath";
document.querySelector("#viewBox").prepend(circlePath);

const slider = document.getElementById('g-reviews');
const slides = slider.querySelectorAll('.content-wrapper .testimonial');
const dotsContainer = slider.querySelector('.wrapper .dots');

createDot();

let items = gsap.utils.toArray(".g-reviews .item"),
    numItems = items.length,
    itemStep = 1 / numItems,
    wrapProgress = gsap.utils.wrap(0, 1),
    snap = gsap.utils.snap(itemStep),
    wrapTracker = gsap.utils.wrap(0, numItems),
    tracker = { item: 0 };

gsap.set(items, {
    motionPath: {
        path: circlePath,
        align: circlePath,
        alignOrigin: [0.5, 0.5],
        end: i => i / items.length
    }, scale: 0.9
});

const tl = gsap.timeline({ paused: true, reversed: true });

tl.to('.g-reviews .wrapper', {
    rotation: 360,
    transformOrigin: 'center',
    duration: 1,
    ease: 'none'
});

tl.to(items, {
    rotation: "-=360",
    transformOrigin: 'center',
    duration: 1,
    ease: 'none',
}, 0);

tl.to(tracker, {
    item: numItems,
    duration: 1,
    ease: 'none',
    modifiers: {
        item(value) {
            return wrapTracker(numItems - Math.round(value))
        }
    }
}, 0);

items.forEach(function (el, i) {

    el.addEventListener("click", function () {
        let current = tracker.item,
            activeItem = i;

        if (i === current) {
            return;
        }

        //set active item to the item that was clicked and remove active class from all items
        document.querySelector('.g-reviews .item.active').classList.remove('active');
        items[activeItem].classList.add('active');

        let diff = current - i;

        if (Math.abs(diff) < numItems / 2) {
            moveWheel(diff * itemStep);
        } else {
            let amt = numItems - Math.abs(diff);

            if (current > i) {
                moveWheel(amt * -itemStep);
            } else {
                moveWheel(amt * itemStep);
            }
        }
    });
});

// start of document load
document.addEventListener("DOMContentLoaded", function () {

    slideShow();
    moveWheel(-itemStep);
    updateNumber()
    
    setInterval(function(){
        moveWheel(-itemStep);
        slideShow();
        updateNumber()
    }, 3000);

    document.getElementById('next').addEventListener("click", function () {
         moveWheel(-itemStep);
         slideShow();
         updateNumber()
    });

    document.getElementById('prev').addEventListener("click", function () {
         moveWheel(itemStep);
         slideShow();
         updateNumber();
    });

});
// end of document load


function createDot() {
    const iconLink = [
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/insurance.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/apple-1.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/circle-dollar.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/train.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/gift-box-heart.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/heart-care.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/pig-piggy-bank.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/insurance.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/apple-1.svg",
        "http://dev.sterlingadministration.com/wp-content/uploads/2024/07/circle-dollar.svg"
    ]
    slides.forEach((item, i) => {
        const dot = document.createElement('div');
        const icons = document.createElement('img');
        icons.src=iconLink[i];
        dot.appendChild(icons);
        dot.classList.add('item');
        i === 0 ? dot.classList.add('active') : '';
        dotsContainer.appendChild(dot);
    });
}

//Actually define the slideShow()
function slideShow() {
    $=jQuery.noConflict();
    let current = $('#content .active');
    let next = current.next().length ? current.next() :  current.siblings().first();

    current.hide().removeClass('active');
    next.fadeIn("slow").addClass('active');
};

function updateNumber(){
    document.getElementById("number").innerText = `${tracker.item+1}/${numItems}`
}

function moveWheel(amount, i, index) {

    let progress = tl.progress();
    tl.progress(wrapProgress(snap(tl.progress() + amount)))
    let next = tracker.item;
    tl.progress(progress);

    document.querySelector('.item.active').classList.remove('active');
    items[next].classList.add('active');

    gsap.to(tl, {
        progress: snap(tl.progress() + amount),
        modifiers: {
            progress: wrapProgress
        }
    });
}
